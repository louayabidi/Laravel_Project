<?php

namespace App\Http\Controllers;

use App\Models\ObjectifSante;
use Illuminate\Http\Request;

class ObjectifSanteController extends Controller
{
    public function index()
    {
        return ObjectifSante::with('user')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'categorie' => 'required|string|max:50',
            'valeur_cible' => 'required|numeric',
            'unite' => 'required|string|max:20',
            'description' => 'nullable|string',
        ]);

        return ObjectifSante::create($validated);
    }

    public function show($id)
    {
        return ObjectifSante::with('user')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $objectif = ObjectifSante::findOrFail($id);
        $objectif->update($request->all());

        return $objectif;
    }

    public function destroy($id)
    {
        return ObjectifSante::destroy($id);
    }
}
