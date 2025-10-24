<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Services\NutritionService;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    protected $nutritionService;

    public function __construct(NutritionService $nutritionService)
    {
        $this->nutritionService = $nutritionService;
    }

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
            'food_name' => 'required|string|max:255',
        ]);

        // Fetch nutritional data from API (assuming 100g for per-gram calculations)
        $nutrition = $this->nutritionService->getNutritionDetails($request->food_name, 100);
        if (!$nutrition) {
            return back()->withErrors(['food_name' => 'Impossible de récupérer les données nutritionnelles pour cet aliment.']);
        }

        Food::create([
            'name' => $nutrition['name'],
            'calories_per_gram' => $nutrition['calories'] / 100,
            'protein_per_gram' => $nutrition['protein'] / 100,
            'carbs_per_gram' => $nutrition['carbs'] / 100,
            'fat_per_gram' => $nutrition['fat'] / 100,
            'sugar_per_gram' => $nutrition['sugar'] / 100,
            'fiber_per_gram' => $nutrition['fiber'] / 100,
        ]);
            $badgeNames = [
    'Healthy Eater',
    'Low Calorie Consumer',
    'Balanced Diet',
    'Sugar Watcher',
    'Fiber Fanatic',
    'Sugar Free'
];

$user = auth()->user();
$data = $request->only([
    'sommeil_heures', 'eau_litres', 'sport_minutes',
    'stress_niveau', 'meditation_minutes',
    'temps_ecran_minutes', 'cafe_cups',
    'calories', 'protein', 'carbs', 'fat', 'sugar', 'fiber'
]);

app(BadgeService::class)->calculateBadgePoints($user, $data);





        return redirect()->route('foods.index')->with('success', 'Aliment créé avec succès.');
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
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
        'calories' => 'required|numeric',
        'protein' => 'required|numeric',
        'carbs' => 'required|numeric',
        'fat' => 'required|numeric',
        'sugar' => 'required|numeric',
        'fiber' => 'required|numeric',
        'is_custom' => 'nullable|boolean',
    ]);

    $food->update([
        'name' => $request->name,
        'category' => $request->category,
        'calories_per_gram' => $request->calories / 100,
        'protein_per_gram' => $request->protein / 100,
        'carbs_per_gram' => $request->carbs / 100,
        'fat_per_gram' => $request->fat / 100,
        'sugar_per_gram' => $request->sugar / 100,
        'fiber_per_gram' => $request->fiber / 100,
        'is_custom' => $request->has('is_custom'),
    ]);

    return redirect()->route('foods.index')->with('success', 'Aliment mis à jour avec succès.');
}


    public function destroy(Food $food)
    {
        $food->delete();
        return redirect()->route('foods.index')->with('success', 'Aliment supprimé avec succès.');
    }

    public function suggestions(Request $request)
    {
        $query = $request->query('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }
        return response()->json($this->nutritionService->searchFoods($query));
    }




}
