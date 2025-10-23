<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Services\NutritionService;
use Illuminate\Http\Request;
use App\Services\BadgeService;
use App\Models\Badge;
class FoodController extends Controller
{
    protected $nutritionService;
    protected $badgeService;

    public function __construct(NutritionService $nutritionService, BadgeService $badgeService)
    {
        $this->nutritionService = $nutritionService;
        $this->badgeService = $badgeService;
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

foreach ($badgeNames as $badgeName) {
    $points = $this->calculateFoodPoints($nutrition, $badgeName);

    if ($points > 0) {
        $badges = Badge::where('name', $badgeName)->get();
        foreach ($badges as $badge) {
            $this->badgeService->addPoints($user, $badge, $points);
        }
    }
}


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
    protected function calculateFoodPoints(array $nutrition,string $badgeName): int
{
    $points = 0;
    switch($badgeName) {
        case 'Healthy Eater':
            if ($nutrition['protein'] >= 10) $points += 2;
            if ($nutrition['fiber'] >= 5) $points += 2;
            if ($nutrition['sugar'] < 5) $points += 1;
            break;
        case 'Low Calorie Consumer':
            if ($nutrition['calories'] < 50) $points += 3;
            break;
        case 'Balanced Diet':
            if ($nutrition['protein'] >= 5 && $nutrition['carbs'] >= 5 && $nutrition['fat'] >= 5) $points += 4;
            break;
        case 'Sugar Watcher':
            if ($nutrition['sugar'] < 3) $points += 2;
            break;
        case 'Fiber Fanatic':
            if ($nutrition['fiber'] >= 1) $points += 10;
            break;
        case 'Sugar Free':
            if ($nutrition['sugar'] == 0) $points += 5;
            break;


        // Add more badge criteria cases as needed
    }


    return $points;
}

}
