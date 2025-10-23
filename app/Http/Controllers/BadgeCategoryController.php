<?php

namespace App\Http\Controllers;

use App\Models\BadgeCategorie;
use Illuminate\Http\Request;

class BadgeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
          $categories = BadgeCategorie::all();
        return view('gamification.categorie.index', compact('categories'))
               ->with('activePage', 'category');


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('gamification.categorie.create')
            ->with('activePage', 'category');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);
          $data = $request->only(['name', 'description']);
          if ($request->hasFile('icon')) {

        $path = $request->file('icon')->store('icons', 'public');
        $data['icon'] = $path;
    }

        // Create category
        BadgeCategorie::create($data);

        // Redirect back with success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BadgeCategorie $category)
    {

        return view('gamification.categorie.show', compact('category'))
            ->with('activePage', 'category');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BadgeCategorie $category)
    {
        return view('gamification.categorie.edit', compact('category'))
            ->with('activePage', 'category');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BadgeCategorie $category)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png,g
if|max:2048'
        ]);
            $data = $request->only(['name', 'description']);
            if ($request->hasFile('icon')) {
        $path = $request->file('icon')->store('icons', 'public');
        $data['icon'] = $path;
            }
            $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BadgeCategorie $category)
    {
        //delete a badge category
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully!');
    }
}
