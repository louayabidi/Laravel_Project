<?php

namespace App\Http\Controllers;

use App\Models\SanteMesure;
use App\Models\Regime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Dompdf\Dompdf;

class SanteMesureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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

        // Préparer les données pour les courbes d'évolution
        $evolutionData = [
            'dates' => $mesures->pluck('date_mesure'),
            'poids' => $mesures->pluck('poids_kg'),
            'imc' => $mesures->pluck('imc'),
            'freq_cardiaque' => $mesures->pluck('freq_cardiaque'),
            'tension' => $mesures->map(fn($m) => [$m->tension_systolique, $m->tension_diastolique])
        ];

        return view('sante_mesures.index', compact('mesures', 'evolutionData'));
    }

    public function show(SanteMesure $sante_mesure)
    {
        $this->authorize('view', $sante_mesure);

        $recommendations = $sante_mesure->getRecommendations();
        $alertes = $sante_mesure->needsAlert();
        $regime = $sante_mesure->regime;

        return view('sante_mesures.show', compact('sante_mesure', 'recommendations', 'alertes', 'regime'));
    }

    public function create()
    {
        return view('sante_mesures.create');
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
            'type_regime' => 'required_if:regime_id,null|in:Fitnesse,musculation,prise_de_poids',
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
            ->with('success', 'Mesure ajoutée avec succès !');
    }

    public function edit(SanteMesure $sante_mesure)
    {
        $this->authorize('update', $sante_mesure);
        return view('sante_mesures.edit', ['mesure' => $sante_mesure]);
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
            'type_regime' => 'required_if:regime_id,null|in:Fitnesse,musculation,prise_de_poids',
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
        $this->authorize('delete', $sante_mesure);
        $sante_mesure->delete();
        return redirect()->route('sante-mesures.index')
            ->with('success', 'Mesure supprimée avec succès !');
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
}
