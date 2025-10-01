<?php
namespace App\Http\Controllers;

use App\Models\Habitude;
use Illuminate\Http\Request;

class HabitudeController extends Controller
{
    public function index()
    {
        $habitudes = Habitude::where('user_id', auth()->id())
            ->orderBy('date_jour', 'desc')
            ->paginate(10);

        return view('habitudes.index', compact('habitudes'));
    }

    public function create()
    {
        return view('habitudes.create');
    }

    public function store(Request $request)
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

        Habitude::create($validated);

        return redirect()->route('habitudes.index')->with('success', 'Habitude ajoutée !');
    }

    public function edit(Habitude $habitude)
    {
        // 🔒 sécurité : empêcher d’éditer les habitudes d’un autre utilisateur
        if ($habitude->user_id !== auth()->id()) {
            abort(403, 'Accès non autorisé.');
        }

        return view('habitudes.edit', compact('habitude'));
    }

    public function update(Request $request, Habitude $habitude)
    {
        if ($habitude->user_id !== auth()->id()) {
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

        return redirect()->route('habitudes.index')->with('success', 'Habitude mise à jour !');
    }

   public function destroy(Habitude $habitude)
{
    if ($habitude->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
        abort(403, 'Accès non autorisé.');
    }

    $habitude->delete();

    if (auth()->user()->isAdmin()) {
        return redirect()->route('habitudes.backIndex')->with('success', 'Habitude supprimée !');
    } else {
        return redirect()->route('habitudes.index')->with('success', 'Habitude supprimée !');
    }
}



    public function show(Habitude $habitude)
{
    return view('habitudes.show', compact('habitude'));
}

public function backIndex()
{
    $habitudes = Habitude::latest()->paginate(10);

    return view('habitudes.backIndex', [
        'habitudes' => $habitudes,
        'activePage' => 'habitudes' // <- nom unique pour Habitude de vie
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
