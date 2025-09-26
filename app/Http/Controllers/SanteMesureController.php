<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanteMesure;

class SanteMesureController extends Controller
{
    public function index()
    {
        $mesures = SanteMesure::all();
        return view('sante_mesures.index', compact('mesures'));
    }

    public function create()
    {
        return view('sante_mesures.create');
    }

    public function store(Request $request)
    {
        SanteMesure::create($request->all());
        return redirect()->route('sante-mesures.index')->with('success', 'Mesure ajoutée avec succès !');
    }

    public function edit(SanteMesure $sante_mesure)
    {
        return view('sante_mesures.edit', ['mesure' => $sante_mesure]);
    }

    public function update(Request $request, SanteMesure $sante_mesure)
    {
        $sante_mesure->update($request->all());
        return redirect()->route('sante-mesures.index')->with('success', 'Mesure mise à jour !');
    }

    public function destroy(SanteMesure $sante_mesure)
    {
        $sante_mesure->delete();
        return redirect()->route('sante-mesures.index')->with('success', 'Mesure supprimée !');
    }
}
