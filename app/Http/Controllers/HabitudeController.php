<?php
namespace App\Http\Controllers;

use App\Models\Habitude;
use Illuminate\Http\Request;
use App\Services\BadgeService;
use App\Models\Badge;
class HabitudeController extends Controller
{
    protected $badgeService;

    public function __construct(BadgeService $badgeService)
    {
        $this->badgeService = $badgeService;
    }

    public function index()
    {
        $habitudes = Habitude::where('user_id', auth()->id())
            ->orderBy('date_jour', 'desc')
            ->paginate(10);

        return view('habitudes.index', compact('habitudes'));
    }

    public function indexByObjectif($objectifId)
{
    $habitudes = Habitude::whereHas('objectif', function($query) {
        $query->where('user_id', auth()->id());
    })
    ->where('objectif_id', $objectifId)
    ->orderBy('date_jour', 'desc')
    ->paginate(10);

    return view('habitudes.index', [
        'habitudes' => $habitudes,
        'objectif_id' => $objectifId,
    ]);
}


    public function create($objectifId)
    {
        return view('habitudes.create', compact('objectifId'));
    }

    public function store(Request $request, $objectifId)
    {
        $validated = $request->validate([
            'date_jour' => 'required|date',
            'sommeil_heures' => 'nullable|numeric|min:0',
            'eau_litres' => 'nullable|numeric|min:0',
            'sport_minutes' => 'nullable|integer|min:0',
            'stress_niveau' => 'nullable|integer|min:0|max:10',
            'meditation_minutes' => 'nullable|integer|min:0',
            'temps_ecran_minutes' => 'nullable|integer|min:0',
            'cafe_cups' => 'nullable|integer|min:0',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['objectif_id'] = $objectifId;

        Habitude::create($validated);
        $user = auth()->user();
         $badgeNames = [
            'Sleep Tracker',
            'Early Riser',
            'Hydration Starter',
            'Water Warrior',
            'Hydration Hero',
            'Active Starter',
            'Fitness Fan',
            'Endurance Pro',
            'Calm Mind',
            'Mindful Starter',
            'Zen Master',
            'Digital Detox',
            'Balanced Energy',
        ];
        foreach ($badgeNames as $badgeName) {
            $points = $this->calculateHabitudePoints($user, $validated, $badgeName);
            if ($points > 0) {
                $badges = Badge::where('name', $badgeName)->get();
                foreach ($badges as $badge) {
                    $this->badgeService->addPoints($user, $badge, $points);
                }
            }
        }

        return redirect()->route('objectifs.habitudes.index', $objectifId)
            ->with('success', 'Habitude ajoutée !');
    }

   public function edit($objectifId, Habitude $habitude)
{
    // Vérifie que l'objectif appartient à l'utilisateur connecté
    if ($habitude->objectif->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé.');
    }

    return view('habitudes.edit', compact('habitude', 'objectifId'));
}

public function update(Request $request, Habitude $habitude)
{
    if ($habitude->objectif->user_id !== auth()->id()) {
        abort(403, 'Accès non autorisé.');
    }

    $validated = $request->validate([
        'date_jour' => 'required|date',
        'sommeil_heures' => 'nullable|numeric|min:0',
        'eau_litres' => 'nullable|numeric|min:0',
        'sport_minutes' => 'nullable|integer|min:0',
        'stress_niveau' => 'nullable|integer|min:0|max:10',
        'meditation_minutes' => 'nullable|integer|min:0',
        'temps_ecran_minutes' => 'nullable|integer|min:0',
        'cafe_cups' => 'nullable|integer|min:0',
    ]);

    $habitude->update($validated);

    return redirect()
        ->route('objectifs.habitudes.index', $habitude->objectif_id)
        ->with('success', 'Habitude mise à jour !');
}


    public function show(Habitude $habitude)
{
    $objectif = $habitude->objectif;
    return view('habitudes.show', compact('habitude', 'objectif'));
}


public function destroy(Habitude $habitude)
{
    if ($habitude->objectif->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403, 'Accès non autorisé.');
    }

    $objectifId = $habitude->objectif_id;
    $habitude->delete();

    if (auth()->user()->isAdmin()) {
        return redirect()->route('habitudes.backIndex')
            ->with('success', 'Habitude supprimée !');
    } else {
        return redirect()->route('objectifs.habitudes.index', $objectifId)
            ->with('success', 'Habitude supprimée !');
    }
}




public function backIndex()
{
    $habitudes = Habitude::latest()->paginate(10);

    return view('habitudes.backIndex', [
        'habitudes' => $habitudes,
        'activePage' => 'habitudes'
    ]);
}



public function backShow()
{
    $habitudes = Habitude::latest()->paginate(10);
    return view('habitudes.backShow', compact('habitudes'));
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
 protected function calculateHabitudePoints($user, array $data, string $badgeName): int
    {
        $points = 0;

        switch ($badgeName) {
            // 💤 SLEEP
            case 'Sleep Tracker':
                if (!empty($data['sommeil_heures']) && $data['sommeil_heures'] >= 7) $points += 10;
                break;

           //

            // 💧 HYDRATION
            case 'Hydration Starter':
                if (!empty($data['eau_litres']) && $data['eau_litres'] >= 1) $points += 5;
                break;
            case 'Water Warrior':
                if (!empty($data['eau_litres']) && $data['eau_litres'] >= 2) $points += 10;
                break;
            case 'Hydration Hero':
                if (!empty($data['eau_litres']) && $data['eau_litres'] >= 3) $points += 20;
                break;

            // 🏃 SPORT
            case 'Active Starter':
                if (!empty($data['sport_minutes']) && $data['sport_minutes'] >= 20) $points += 10;
                break;
            case 'Fitness Fan':
                if (!empty($data['sport_minutes']) && $data['sport_minutes'] >= 45) $points += 20;
                break;
            case 'Endurance Pro':
                if (!empty($data['sport_minutes']) && $data['sport_minutes'] >= 60) $points += 40;
                break;

            // 🧘 STRESS & MEDITATION
            case 'Calm Mind':
                if (isset($data['stress_niveau']) && $data['stress_niveau'] <= 3) $points += 15;
                break;
            case 'Mindful Starter':
                if (!empty($data['meditation_minutes']) && $data['meditation_minutes'] >= 10) $points += 15;
                break;
            case 'Zen Master':
                if (!empty($data['meditation_minutes']) && $data['meditation_minutes'] >= 30) $points += 25;
                break;

            // 📱 SCREEN TIME
            case 'Digital Detox':
                if (!empty($data['temps_ecran_minutes']) && $data['temps_ecran_minutes'] <= 120) $points += 10;
                break;

            // ☕ COFFEE
            case 'Balanced Energy':
                if ( $data['cafe_cups'] <= 2) $points += 10;
                break;
        }

        return $points;
    }


}
