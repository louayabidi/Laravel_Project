<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::paginate(10);
        return view('alimentaire.food.index', compact('foods'))->with('activePage', 'foods');
    }

    public function create()
    {
        return view('alimentaire.food.create')->with('activePage', 'foods');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'calories' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
            'sugar' => 'required|numeric',
            'fiber' => 'required|numeric',
            'is_custom' => 'boolean',
        ]);

        Food::create($request->all());
        return redirect()->route('foods.index')->with('success', 'Food created successfully.');
    }

    public function show(Food $food)
    {
        return view('alimentaire.food.show', compact('food'))->with('activePage', 'foods');
    }

    public function edit(Food $food)
    {
        return view('alimentaire.food.edit', compact('food'))->with('activePage', 'foods');
    }

    public function update(Request $request, Food $food)
    {
        $request->validate([
            'name' => 'required|string',
            'category' => 'required|string',
            'calories' => 'required|numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
            'sugar' => 'required|numeric',
            'fiber' => 'required|numeric',
            'is_custom' => 'boolean',
        ]);

        $food->update($request->all());
        return redirect()->route('foods.index')->with('success', 'Food updated successfully.');
    }

    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('foods.index')->with('success', 'Food deleted successfully.');
    }
}