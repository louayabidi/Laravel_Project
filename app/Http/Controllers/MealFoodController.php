<?php

namespace App\Http\Controllers;

use App\Models\MealFood;
use App\Models\Meal;
use App\Models\Food;
use Illuminate\Http\Request;

class MealFoodController extends Controller
{
    public function index()
    {
        $mealFoods = MealFood::paginate(10);
        return view('alimentaire..meal-food.index', compact('mealFoods'))->with('activePage', 'alimentaire..meal-food');
    }

    public function create()
    {
        $meals = Meal::all();
        $foods = Food::all();
        return view('alimentaire..meal-food.create', compact('meals', 'foods'))->with('activePage', 'alimentaire..meal-food');
    }

    public function store(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|numeric',
            'calories_total' => 'required|numeric',
            'protein_total' => 'required|numeric',
            'carbs_total' => 'required|numeric',
            'fat_total' => 'required|numeric',
        ]);

        MealFood::create($request->all());
        return redirect()->route('alimentaire..meal-food.index')->with('success', 'Meal Food created successfully.');
    }

    public function show(MealFood $mealFood)
    {
        return view('alimentaire..meal-food.show', compact('mealFood'))->with('activePage', 'alimentaire..meal-food');
    }

    public function edit(MealFood $mealFood)
    {
        $meals = Meal::all();
        $foods = Food::all();
        return view('alimentaire..meal-food.edit', compact('mealFood', 'meals', 'foods'))->with('activePage', 'alimentaire..meal-food');
    }

    public function update(Request $request, MealFood $mealFood)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'food_id' => 'required|exists:foods,id',
            'quantity' => 'required|numeric',
            'calories_total' => 'required|numeric',
            'protein_total' => 'required|numeric',
            'carbs_total' => 'required|numeric',
            'fat_total' => 'required|numeric',
        ]);

        $mealFood->update($request->all());
        return redirect()->route('alimentaire..meal-food.index')->with('success', 'Meal Food updated successfully.');
    }

    public function destroy(MealFood $mealFood)
    {
        $mealFood->delete();
        return redirect()->route('alimentaire..meal-food.index')->with('success', 'Meal Food deleted successfully.');
    }
}