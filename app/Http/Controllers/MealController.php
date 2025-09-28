<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Food;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function index()
    {
        $meals = Meal::paginate(10);
        return view('alimentaire.meals.index', compact('meals'))->with('activePage', 'meals');
    }

    public function create()
    {
        $foods = Food::all(); // For adding foods to meal
        return view('alimentaire.meals.create', compact('foods'))->with('activePage', 'meals');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'foods' => 'sometimes|array',
            'foods.*.food_id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|numeric|min:0',
        ]);

        $meal = Meal::create([
            'user_id' => 1, // Static
            'type' => $request->type,
            'date' => $request->date,
        ]);

        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                $food = Food::findOrFail($foodData['food_id']);
                $quantity = $foodData['quantity'];
                $meal->mealFoods()->create([
                    'food_id' => $food->id,
                    'quantity' => $quantity,
                    'calories_total' => $food->calories * $quantity,
                    'protein_total' => $food->protein * $quantity,
                    'carbs_total' => $food->carbs * $quantity,
                    'fat_total' => $food->fat * $quantity,
                ]);
            }
        }

        return redirect()->route('meals.index')->with('success', 'Meal created successfully.');
    }

    public function show(Meal $meal)
    {
        $meal->load('mealFoods.food');
        return view('alimentaire.meals.show', compact('meal'))->with('activePage', 'meals');
    }

    public function edit(Meal $meal)
    {
        $foods = Food::all();
        $meal->load('mealFoods');
        return view('alimentaire.meals.edit', compact('meal', 'foods'))->with('activePage', 'meals');
    }

    public function update(Request $request, Meal $meal)
    {
        $request->validate([
            'type' => 'required|in:breakfast,lunch,dinner,snack',
            'date' => 'required|date',
            'foods' => 'sometimes|array',
            'foods.*.food_id' => 'required|exists:foods,id',
            'foods.*.quantity' => 'required|numeric|min:0',
        ]);

        $meal->update([
            'type' => $request->type,
            'date' => $request->date,
        ]);

        $meal->mealFoods()->delete();
        if ($request->has('foods')) {
            foreach ($request->foods as $foodData) {
                $food = Food::findOrFail($foodData['food_id']);
                $quantity = $foodData['quantity'];
                $meal->mealFoods()->create([
                    'food_id' => $food->id,
                    'quantity' => $quantity,
                    'calories_total' => $food->calories * $quantity,
                    'protein_total' => $food->protein * $quantity,
                    'carbs_total' => $food->carbs * $quantity,
                    'fat_total' => $food->fat * $quantity,
                ]);
            }
        }

        return redirect()->route('meals.index')->with('success', 'Meal updated successfully.');
    }

    public function destroy(Meal $meal)
    {
        $meal->delete();
        return redirect()->route('meals.index')->with('success', 'Meal deleted successfully.');
    }
}