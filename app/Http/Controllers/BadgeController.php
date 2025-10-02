<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use Illuminate\Http\Request;
use App\Models\BadgeCategorie;

class BadgeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
{
    $categories = BadgeCategorie::all();
    $selectedCategoryId = $request->query('badge_categorie_id'); // ✅ reads query parameter

    return view('gamification.badge.create', [
        'activePage' => 'badges',
        'categories' => $categories,
        'selectedCategoryId' => $selectedCategoryId
    ]);
}


    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'badge_categorie_id' => 'required|exists:badge_categories,id',
            'criteria' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'badge_categorie_id', 'criteria']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
            $data['image'] = $path;
        }

        // Create badge
        Badge::create($data);

        // Redirect back with success message
        return redirect()->route('categories.show', $request->badge_categorie_id)->with('success', 'Badge created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Badge $badge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Badge $badge)
    {
        return view('gamification.badge.edit', compact('badge'))
            ->with('activePage', 'badges');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Badge $badge)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'criteria' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'description', 'criteria']);
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('badges', 'public');
            $data['image'] = $path;
        }

        $badge->update($data);

        return redirect()->route('categories.show', $badge->badge_categorie_id)->with('success', 'Badge updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Badge $badge)
    {
        // Delete badge
        $badge->delete();
        return redirect()->route('categories.show', $badge->badge_categorie_id)->with('success', 'Badge deleted successfully!');
    }
}
