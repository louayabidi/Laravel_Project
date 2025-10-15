<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\MealFood;
use App\Models\Food;
use Illuminate\Http\Request;
use App\Models\FoodGoal;
use Illuminate\Support\Facades\Log; 
use GuzzleHttp\Client;

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

    public function showAddByImageForm()
    {
        return view('alimentaire.meals.add-by-image')->with('activePage', 'meals');
    }

  public function addByImage(Request $request)
    {
        Log::info('POST /meals/add-by-image received', $request->all());
        try {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
                'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            ]);
            Log::info('Validation passed', $validated);

            $userId = auth()->id();
            if (!$userId) {
                Log::error('No authenticated user');
                return redirect()->back()->with('error', 'Vous devez être connecté.');
            }
            Log::info('User ID: ' . $userId);
            $today = now()->format('Y-m-d');

            $meal = Meal::firstOrCreate([
                'user_id' => $userId,
                'type' => $request->meal_type,
                'date' => $today,
            ]);
            Log::info('Meal created/found: ', $meal->toArray());

            $imagePath = $request->file('image')->getPathname();
            Log::info('Image path: ' . $imagePath);

            // Determine Content-Type based on image MIME type
            $mimeType = $request->file('image')->getMimeType();
            if (!in_array($mimeType, ['image/jpeg', 'image/png', 'image/jpg'])) {
                Log::error('Unsupported image MIME type', ['mime_type' => $mimeType]);
                $meal->delete();
                return redirect()->back()->with('error', 'Format d\'image non supporté. Utilisez JPEG ou PNG.');
            }
            Log::info('Image MIME type: ' . $mimeType);

            $hfClient = new Client();
            try {
                $hfResponse = $hfClient->request('POST', 'https://api-inference.huggingface.co/models/nateraw/food', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('HUGGING_FACE_API_KEY'),
                        'Content-Type' => $mimeType,
                        'User-Agent' => 'Laravel/' . app()->version(),
                    ],
                    'body' => fopen($imagePath, 'r'),
                    'timeout' => 30,
                ]);
                $hfBody = $hfResponse->getBody()->getContents();
                Log::info('Hugging Face API response', ['status' => $hfResponse->getStatusCode(), 'body' => $hfBody]);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                Log::error('Hugging Face API request failed', [
                    'message' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null,
                    'request_id' => $e->hasResponse() ? $e->getResponse()->getHeaderLine('x-amzn-RequestId') : null,
                ]);
                $meal->delete();
                return redirect()->back()->with('error', 'Erreur lors de l\'analyse de l\'image. Réessayez plus tard.');
            }

            $recognizedFoods = json_decode($hfBody, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Failed to decode Hugging Face API response', ['error' => json_last_error_msg()]);
                throw new \Exception('Invalid response from image recognition API.');
            }

            if (empty($recognizedFoods) || !is_array($recognizedFoods)) {
                Log::warning('No foods recognized by Hugging Face API', ['response' => $recognizedFoods]);
                $meal->delete();
                return redirect()->back()->with('error', 'Aucun aliment détecté dans l\'image.');
            }

            Log::info('All recognized foods: ', $recognizedFoods);

            $mealFoodsCreated = 0;
            foreach ($recognizedFoods as $food) {
                Log::info('Processing food: ', ['label' => $food['label'], 'score' => $food['score']]);
                if ($food['score'] < env('HUGGING_FACE_CONFIDENCE_THRESHOLD', 0.2)) {
                    Log::info('Skipping food due to low confidence score: ' . $food['label'] . ' (score: ' . $food['score'] . ')');
                    continue;
                }

                $foodLabel = str_replace('_', ' ', $food['label']);
                $foodLabel = preg_replace('/[^a-zA-Z\s]/', '', $foodLabel);
                $foodLabel = trim($foodLabel);
                Log::info('Food label: ' . $foodLabel);

                $usdaClient = new Client();
                try {
                    $usdaResponse = $usdaClient->request('GET', 'https://api.nal.usda.gov/fdc/v1/foods/search', [
                        'query' => [
                            'query' => $foodLabel,
                            'api_key' => env('USDA_API_KEY'),
                            'pageSize' => 1,
                        ],
                    ]);
                    $usdaBody = $usdaResponse->getBody()->getContents();
                    Log::info('USDA API raw response', ['status' => $usdaResponse->getStatusCode(), 'body' => $usdaBody]);

                    $usdaData = json_decode($usdaBody, true)['foods'][0] ?? null;
                    if (!$usdaData) {
                        Log::warning('No USDA data for food: ' . $foodLabel);
                        continue;
                    }
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    Log::error('USDA API request failed', [
                        'message' => $e->getMessage(),
                        'code' => $e->getCode(),
                        'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null,
                    ]);
                    continue;
                }

                $nutrients = collect($usdaData['foodNutrients']);
                $calories = $nutrients->firstWhere('nutrientName', 'Energy')['value'] ?? 0;
                $protein = $nutrients->firstWhere('nutrientName', 'Protein')['value'] ?? 0;
                $carbs = $nutrients->firstWhere('nutrientName', 'Carbohydrate, by difference')['value'] ?? 0;
                $fat = $nutrients->firstWhere('nutrientName', 'Total lipid (fat)')['value'] ?? 0;
                $sugar = $nutrients->firstWhere('nutrientName', 'Total Sugars')['value'] ?? 0;
                $fiber = $nutrients->firstWhere('nutrientName', 'Fiber, total dietary')['value'] ?? 0;

                $foodModel = Food::firstOrCreate(
                    ['name' => $foodLabel],
                    [
                        'calories_per_gram' => $calories / 100,
                        'protein_per_gram' => $protein / 100,
                        'carbs_per_gram' => $carbs / 100,
                        'fat_per_gram' => $fat / 100,
                        'sugar_per_gram' => $sugar / 100,
                        'fiber_per_gram' => $fiber / 100,
                    ]
                );

                MealFood::create([
                    'meal_id' => $meal->id,
                    'food_id' => $foodModel->id,
                    'name' => $foodLabel,
                    'quantity' => 100,
                    'calories_total' => $calories,
                    'protein_total' => $protein,
                    'carbs_total' => $carbs,
                    'fat_total' => $fat,
                    'sugar_total' => $sugar,
                    'fiber_total' => $fiber,
                    'recognized_by_ai' => true,
                ]);
                $mealFoodsCreated++;
            }

            if ($mealFoodsCreated === 0) {
                Log::warning('No valid foods were added to the meal', ['meal_id' => $meal->id]);
                $meal->delete();
                return redirect()->back()->with('error', 'Aucun aliment valide détecté dans l\'image. Essayez une autre image ou ajoutez manuellement.');
            }

            return redirect()->route('meals.index')->with('success', 'Aliments reconnus et ajoutés au repas !');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error during image recognition or nutrition fetch: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur lors de l\'analyse de l\'image.');
        }
    }
}
