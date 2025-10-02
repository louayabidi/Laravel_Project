<?php

namespace App\Http\Controllers;

use App\Models\MealFood;
use App\Models\Meal;
use App\Models\Food;
use App\Services\NutritionService;
use Illuminate\Http\Request;

class MealFoodController extends Controller
{
    public function index()
    {
        $mealFoods = MealFood::with(['meal', 'food'])->paginate(10);
        return view('alimentaire.meal-food.index', compact('mealFoods'))->with('activePage', 'meal-foods');
    }

    public function create()
    {
        $meals = Meal::all();
        return view('alimentaire.meal-food.create', compact('meals'))->with('activePage', 'meal-foods');
    }

    public function store(Request $request)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $nutritionService = new NutritionService();
        $nutrition = $nutritionService->getNutritionDetails($request->food_name, $request->quantity);

        if (!$nutrition) {
            return back()->withErrors(['food_name' => 'Impossible de récupérer les données nutritionnelles. Vérifiez le nom de l\'aliment.']);
        }

        $food = Food::firstOrCreate(
            ['name' => $nutrition['name']],
            [
                'calories_per_gram' => $nutrition['calories'] / $request->quantity,
                'protein_per_gram' => $nutrition['protein'] / $request->quantity,
                'carbs_per_gram' => $nutrition['carbs'] / $request->quantity,
                'fat_per_gram' => $nutrition['fat'] / $request->quantity,
                'sugar_per_gram' => $nutrition['sugar'] / $request->quantity,
                'fiber_per_gram' => $nutrition['fiber'] / $request->quantity,
            ]
        );

        MealFood::create([
            'meal_id' => $request->meal_id,
            'food_id' => $food->id,
            'quantity' => $request->quantity,
            'calories_total' => $nutrition['calories'],
            'protein_total' => $nutrition['protein'],
            'carbs_total' => $nutrition['carbs'],
            'fat_total' => $nutrition['fat'],
            'sugar_total' => $nutrition['sugar'],
            'fiber_total' => $nutrition['fiber'],
        ]);

        return redirect()->route('meal-foods.index')->with('success', 'Aliment de repas créé avec succès.');
    }

    public function suggestions(Request $request)
    {
        $query = $request->get('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $nutritionService = new NutritionService();
        $suggestions = $nutritionService->searchFoods($query);
        return response()->json($suggestions);
    }

    public function show(MealFood $mealFood)
    {
        $mealFood->load(['meal', 'food']);
        return view('alimentaire.meal-food.show', compact('mealFood'))->with('activePage', 'meal-foods');
    }

    public function edit(MealFood $mealFood)
    {
        $meals = Meal::all();
        return view('alimentaire.meal-food.edit', compact('mealFood', 'meals'))->with('activePage', 'meal-foods');
    }

    public function update(Request $request, MealFood $mealFood)
    {
        $request->validate([
            'meal_id' => 'required|exists:meals,id',
            'food_name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0.01',
        ]);

        $nutritionService = new NutritionService();
        $nutrition = $nutritionService->getNutritionDetails($request->food_name, $request->quantity);

        if (!$nutrition) {
            return back()->withErrors(['food_name' => 'Impossible de récupérer les données nutritionnelles.']);
        }

        $food = Food::firstOrCreate(
            ['name' => $nutrition['name']],
            [
                'calories_per_gram' => $nutrition['calories'] / $request->quantity,
                'protein_per_gram' => $nutrition['protein'] / $request->quantity,
                'carbs_per_gram' => $nutrition['carbs'] / $request->quantity,
                'fat_per_gram' => $nutrition['fat'] / $request->quantity,
                'sugar_per_gram' => $nutrition['sugar'] / $request->quantity,
                'fiber_per_gram' => $nutrition['fiber'] / $request->quantity,
            ]
        );

        $mealFood->update([
            'meal_id' => $request->meal_id,
            'food_id' => $food->id,
            'quantity' => $request->quantity,
            'calories_total' => $nutrition['calories'],
            'protein_total' => $nutrition['protein'],
            'carbs_total' => $nutrition['carbs'],
            'fat_total' => $nutrition['fat'],
            'sugar_total' => $nutrition['sugar'],
            'fiber_total' => $nutrition['fiber'],
        ]);

        return redirect()->route('meal-foods.index')->with('success', 'Aliment de repas mis à jour avec succès.');
    }

    public function destroy(MealFood $mealFood)
    {
        $mealFood->delete();
        return redirect()->route('meal-foods.index')->with('success', 'Aliment de repas supprimé avec succès.');
    }
}