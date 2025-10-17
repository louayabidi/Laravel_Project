<?php

namespace App\Http\Controllers;

use App\Models\SanteMesure;
use App\Models\Regime;
use App\Services\HealthAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;

class SanteMesureController extends Controller
{
    protected $healthAnalysisService;

    public function __construct(HealthAnalysisService $healthAnalysisService)
    {
        $this->middleware('auth');
        $this->healthAnalysisService = $healthAnalysisService;
    }

    public function index(Request $request)
    {
        $query = Auth::user()->santeMesures();

        // Filtrage par date
        if ($request->filled('date_debut')) {
            $query->where('date_mesure', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->where('date_mesure', '<=', $request->date_fin);
        }

        $mesures = $query->with('regime')->orderBy('date_mesure', 'desc')
                        ->paginate(10);

        // Get user's health measurements

        // Analyser les tendances de santé avec l'IA
        $healthAnalysis = $this->healthAnalysisService->analyzeHealthTrends(Auth::user(), 30);

        // Préparer les données pour les courbes d'évolution (sans pagination pour les graphiques)
        $allMesures = Auth::user()->santeMesures()
            ->when($request->filled('date_debut'), fn($q) => $q->where('date_mesure', '>=', $request->date_debut))
            ->when($request->filled('date_fin'), fn($q) => $q->where('date_mesure', '<=', $request->date_fin))
            ->orderBy('date_mesure', 'asc')
            ->get();

        $evolutionData = [
            'dates' => $allMesures->pluck('date_mesure')->map(fn($date) => $date->format('Y-m-d'))->values()->toArray(),
            'poids' => $allMesures->pluck('poids_kg')->values()->toArray(),
            'imc' => $allMesures->pluck('imc')->values()->toArray(),
            'freq_cardiaque' => $allMesures->pluck('freq_cardiaque')->values()->toArray(),
            'tension' => $allMesures->map(fn($m) => [$m->tension_systolique, $m->tension_diastolique])->values()->toArray()
        ];

        return view('sante-mesures.index', compact('mesures', 'evolutionData', 'healthAnalysis'));
    }

    public function show(SanteMesure $sante_mesure)
    {
        $this->authorize('view', $sante_mesure);

        $recommendations = $sante_mesure->getRecommendations();
        $alertes = $sante_mesure->needsAlert();
        $regime = $sante_mesure->regime;

        // Analyser les tendances de santé avec l'IA pour cette mesure spécifique
        $healthAnalysis = $this->healthAnalysisService->analyzeHealthTrends($sante_mesure->user, 30);

        // Vérifier si c'est une nouvelle mesure (créée à l'instant)
        $showToast = session('show_modal', false);
        $toastData = session('modal_data', null);

        return view('sante-mesures.show', compact('sante_mesure', 'recommendations', 'alertes', 'regime', 'healthAnalysis', 'showToast', 'toastData'));
    }

    public function create()
    {
        return view('sante-mesures.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'date_mesure' => 'required|date|before_or_equal:today',
            'poids_kg' => 'required|numeric|between:20,300',
            'taille_cm' => 'required|integer|between:50,300',
            'freq_cardiaque' => 'required|integer|between:30,220',
            'tension_systolique' => 'required|integer|between:70,250',
            'tension_diastolique' => 'required|integer|between:40,150',
            'remarque' => 'nullable|string|max:1000',
            'regime_id' => 'nullable|exists:regimes,id',
            'type_regime' => 'required_if:regime_id,null|in:Diabète,Hypertension,Grossesse,Cholestérol élevé (hypercholestérolémie),Maladie cœliaque (intolérance au gluten),Insuffisance rénale',
            'valeur_cible' => 'required_if:regime_id,null|numeric',
            'description' => 'nullable|string|max:1000'
        ]);

        $mesureData = $request->only([
            'date_mesure', 'poids_kg', 'taille_cm', 'freq_cardiaque',
            'tension_systolique', 'tension_diastolique', 'remarque'
        ]);
        $mesureData['user_id'] = Auth::id();

        if ($request->filled('regime_id')) {
            $mesureData['regime_id'] = $request->regime_id;
        } else {
            // Create new regime
            $regimeData = $request->only(['type_regime', 'valeur_cible', 'description']);
            $regime = Regime::create($regimeData);
            $mesureData['regime_id'] = $regime->id;
        }

        $mesure = SanteMesure::create($mesureData);

        // Vérifier les alertes
        if ($mesure->needsAlert()) {
            session()->flash('alert', 'Certaines mesures nécessitent votre attention.');
        }

        return redirect()->route('sante-mesures.show', $mesure)
            ->with('success', 'Mesure ajoutée avec succès !')
            ->with('show_modal', true)
            ->with('modal_data', [
                'imc' => $mesure->imc,
                'poids' => $mesure->poids_kg,
                'tension' => $mesure->tension_systolique . '/' . $mesure->tension_diastolique,
                'freq_cardiaque' => $mesure->freq_cardiaque,
                'regime_type' => $mesure->regime->type_regime ?? 'Non spécifié'
            ]);
    }

    public function edit(SanteMesure $sante_mesure)
    {
        $this->authorize('update', $sante_mesure);
        return view('sante-mesures.edit', ['mesure' => $sante_mesure]);
    }

    public function update(Request $request, SanteMesure $sante_mesure)
    {
        $this->authorize('update', $sante_mesure);

        $validated = $request->validate([
            'date_mesure' => 'required|date|before_or_equal:today',
            'poids_kg' => 'required|numeric|between:20,300',
            'taille_cm' => 'required|integer|between:50,300',
            'freq_cardiaque' => 'required|integer|between:30,220',
            'tension_systolique' => 'required|integer|between:70,250',
            'tension_diastolique' => 'required|integer|between:40,150',
            'remarque' => 'nullable|string|max:1000',
            'regime_id' => 'nullable|exists:regimes,id',
            'type_regime' => 'required_if:regime_id,null|in:Diabète,Hypertension,Grossesse,Cholestérol élevé (hypercholestérolémie),Maladie cœliaque (intolérance au gluten),Insuffisance rénale',
            'valeur_cible' => 'required_if:regime_id,null|numeric',
            'description' => 'nullable|string|max:1000'
        ]);

        $mesureData = $request->only([
            'date_mesure', 'poids_kg', 'taille_cm', 'freq_cardiaque',
            'tension_systolique', 'tension_diastolique', 'remarque'
        ]);

        if ($request->filled('regime_id')) {
            $mesureData['regime_id'] = $request->regime_id;
        } else {
            // Update or create regime
            $regimeData = $request->only(['type_regime', 'valeur_cible', 'description']);
            if ($sante_mesure->regime) {
                $sante_mesure->regime->update($regimeData);
            } else {
                $regime = Regime::create($regimeData);
                $mesureData['regime_id'] = $regime->id;
            }
        }

        $sante_mesure->update($mesureData);

        return redirect()->route('sante-mesures.show', $sante_mesure)
            ->with('success', 'Mesure mise à jour avec succès !');
    }

    public function destroy(SanteMesure $sante_mesure)
    {

     if ($sante_mesure->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403, 'Accès non autorisé.');
    }

    $sante_mesure->delete();

    if (auth()->user()->isAdmin()) {
        return redirect()->route('sante-mesures.backIndex')->with('success', 'Mesure de santé supprimée !');
    } else {
        return redirect()->route('sante-mesures.index')->with('success', 'Mesure de snaté supprimée !');
    }
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->input('date_debut');
        $endDate = $request->input('date_fin');

        // Format dates for display
        $formattedStartDate = $startDate ? Carbon::parse($startDate)->format('d/m/Y') : null;
        $formattedEndDate = $endDate ? Carbon::parse($endDate)->format('d/m/Y') : null;

        $mesures = Auth::user()->santeMesures()->with('regime')
            ->when($startDate, fn($q) => $q->where('date_mesure', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('date_mesure', '<=', $endDate))
            ->orderBy('date_mesure')
            ->get();

        $user = Auth::user();
        $data = [
            'mesures' => $mesures,
            'user' => $user,
            'date_debut' => $formattedStartDate,
            'date_fin' => $formattedEndDate,
            'date_generation' => Carbon::now()->format('d/m/Y H:i')
        ];

        $html = view('exports.sante-mesures-pdf', $data)->render();

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'mesures_sante_' . Carbon::now()->format('Y-m-d') . '.pdf';

        return response($dompdf->output())
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    public function backIndex()
{
    $sante_mesure = SanteMesure::latest()->paginate(10);
    return view('sante-mesures.backIndex', [
    'mesures' => $sante_mesure,
    'activePage' => 'sante'
]);

}


public function backShow(SanteMesure $sante_mesure)
{
    $this->authorize('view', $sante_mesure);

        $recommendations = $sante_mesure->getRecommendations();
        $alertes = $sante_mesure->needsAlert();
        $regime = $sante_mesure->regime;

    return view('sante-mesures.backShow', compact('sante_mesure', 'recommendations', 'alertes', 'regime'));
}
}
