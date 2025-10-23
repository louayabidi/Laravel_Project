<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealFood;
use App\Models\Food;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::where('user_id', auth()->id())->with('mealFoods.food')->paginate(10);
        return view('alimentaire.meals.index', compact('meals'))->with('activePage', 'meals');
    }

    public function create()
    {
        $foods = Food::orderBy('name')->get(); // Fetch all foods for the dropdown
        return view('alimentaire.meals.create', compact('foods'))->with('activePage', 'meals');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'foods.*.food_id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $meal = Meal::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'date' => $request->date,
        ]);

        foreach ($request->foods as $foodData) {
            $food = Food::find($foodData['food_id']);
            if (!$food) {
                $meal->delete();
                return back()->withErrors(['foods' => "Aliment non trouvé: ID {$foodData['food_id']}."]);
            }

            MealFood::create([
                'meal_id' => $meal->id,
                'food_id' => $food->id,
                'quantity' => $foodData['quantity'],
                'calories_total' => $food->calories_per_gram * $foodData['quantity'],
                'protein_total' => $food->protein_per_gram * $foodData['quantity'],
                'carbs_total' => $food->carbs_per_gram * $foodData['quantity'],
                'fat_total' => $food->fat_per_gram * $foodData['quantity'],
                'sugar_total' => $food->sugar_per_gram * $foodData['quantity'],
                'fiber_total' => $food->fiber_per_gram * $foodData['quantity'],
            ]);
        }

        return redirect()->route('meals.index')->with('success', 'Repas créé avec succès.');
    }

    public function show(Meal $meal)
    {
        $meal->load('mealFoods.food');
        $totals = $meal->getTotals();
        return view('alimentaire.meals.show', compact('meal', 'totals'))->with('activePage', 'meals');
    }

    public function edit(Meal $meal)
    {
        $foods = Food::orderBy('name')->get(); // Fetch all foods for the dropdown
        $meal->load('mealFoods.food');
        return view('alimentaire.meals.edit', compact('meal', 'foods'))->with('activePage', 'meals');
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'foods.*.food_id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $meal->update([
            'type' => $request->type,
            'date' => $request->date,
        ]);

        $meal->mealFoods()->delete();
        foreach ($request->foods as $foodData) {
            $food = Food::find($foodData['food_id']);
            if (!$food) {
                return back()->withErrors(['foods' => "Aliment non trouvé: ID {$foodData['food_id']}."]);
            }

            MealFood::create([
                'meal_id' => $meal->id,
                'food_id' => $food->id,
                'quantity' => $foodData['quantity'],
                'calories_total' => $food->calories_per_gram * $foodData['quantity'],
                'protein_total' => $food->protein_per_gram * $foodData['quantity'],
                'carbs_total' => $food->carbs_per_gram * $foodData['quantity'],
                'fat_total' => $food->fat_per_gram * $foodData['quantity'],
                'sugar_total' => $food->sugar_per_gram * $foodData['quantity'],
                'fiber_total' => $food->fiber_per_gram * $foodData['quantity'],
            ]);
        }

        return redirect()->route('meals.index')->with('success', 'Repas mis à jour avec succès.');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return redirect()->route('meals.index')->with('success', 'Repas supprimé avec succès.');
    }
}