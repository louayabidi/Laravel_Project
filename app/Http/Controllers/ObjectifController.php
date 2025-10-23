<?php

namespace App\Http\Controllers;

use App\Models\Objectif;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\StoreObjectifRequest;


class ObjectifController extends Controller
{

public function index(Request $request)
{
    $userId = auth()->id();
    $objectifs = Objectif::with('habitudes')
                    ->where('user_id', auth()->id())
                    ->paginate(10);

    return view('objectifs.index', compact('objectifs'));
}



    public function create()
    {
        return view('objectifs.create');
    }

public function store(StoreObjectifRequest $request)
{
    $data = $request->validated();

    $data['user_id'] = auth()->id();

    Objectif::create($data);

    return redirect()
        ->route('objectifs.index')
        ->with('success', 'Objectif ajouté avec succès !');
}

    public function edit(Objectif $objectif)
    {
        return view('objectifs.edit', compact('objectif'));
    }

    public function update(Request $request, Objectif $objectif)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'target_value' => 'required|integer|min:1',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'status' => 'required|in:Sommeil,Eau,Sport,Stress',
    ]);

    $objectif->update($data);

    return redirect()->route('objectifs.index')->with('success', 'Objectif mis à jour avec succès !');
}


    public function destroy($id)
{
    $objectif = Objectif::findOrFail($id);
    $objectif->delete();

    if (auth()->user()->isAdmin()) {
    return redirect()->route('admin.objectifs.habitudes')
        ->with('success', 'Objectif et habitudes supprimés !');
} else {
    return redirect()->route('objectifs.index')
        ->with('success', 'Objectif et habitudes supprimés !');
}

}


    public function show(Objectif $objectif)
    {
        return redirect()->route('objectifs.habitudes.index', ['objectif_id' => $objectif->id]);
    }

    public function backIndex()
{
$objectifs = Objectif::with('habitudes')->latest()->paginate(10);

    return view('objectifs.backIndex', compact('objectifs'));
}

}
