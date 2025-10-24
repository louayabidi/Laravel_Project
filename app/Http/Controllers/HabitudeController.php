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
        $data = $request->only([
            'sommeil_heures', 'eau_litres', 'sport_minutes',
            'stress_niveau', 'meditation_minutes',
            'temps_ecran_minutes', 'cafe_cups',
            'calories', 'protein', 'carbs', 'fat', 'sugar', 'fiber'
        ]);

        app(BadgeService::class)->calculateBadgePoints($user, $data);

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


}
