<?php

namespace App\Http\Controllers;

use App\Models\FoodGoal;
use Illuminate\Http\Request;

class FoodGoalController extends Controller
{
    public function index()
    {
        $goals = FoodGoal::where('user_id', auth()->id() ?? 1)->paginate(10);
        return view('alimentaire.goals.index', compact('goals'))->with('activePage', 'goals');
    }

    public function create()
    {
        return view('alimentaire.goals.create')->with('activePage', 'goals');
    }

    public function store(Request $request)
    {
        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:20|max:500',
            'height' => 'required|numeric|min:50|max:300',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active',
            'goal_type' => 'required|in:lose,maintain,gain',
            'daily_protein' => 'nullable|numeric|min:0|max:1000',
            'daily_carbs' => 'nullable|numeric|min:0|max:1000',
            'daily_fat' => 'nullable|numeric|min:0|max:1000',
        ]);

        $calc = FoodGoal::calculateBmrAndCalories(
            $request->age,
            $request->gender,
            $request->weight,
            $request->height,
            $request->activity_level,
            $request->goal_type
        );

        FoodGoal::create([
            'user_id' => auth()->id() ?? 1,
            'age' => $request->age,
            'gender' => $request->gender,
            'weight' => $request->weight,
            'height' => $request->height,
            'activity_level' => $request->activity_level,
            'goal_type' => $request->goal_type,
            'bmr' => $calc['bmr'],
            'daily_calories' => $calc['daily_calories'],
            'daily_protein' => $request->daily_protein ?? $calc['daily_calories'] * 0.25 / 4,
            'daily_carbs' => $request->daily_carbs ?? $calc['daily_calories'] * 0.50 / 4,
            'daily_fat' => $request->daily_fat ?? $calc['daily_calories'] * 0.25 / 9,
        ]);

        return redirect()->route('goals.index')->with('success', 'Objectif alimentaire créé avec succès.');
    }

    public function show(FoodGoal $goal)
    {
        return view('alimentaire.goals.show', compact('goal'))->with('activePage', 'goals');
    }

    public function edit(FoodGoal $goal)
    {
        return view('alimentaire.goals.edit', compact('goal'))->with('activePage', 'goals');
    }

    public function update(Request $request, FoodGoal $goal)
    {
        $request->validate([
            'age' => 'required|integer|min:1|max:120',
            'gender' => 'required|in:male,female',
            'weight' => 'required|numeric|min:20|max:500',
            'height' => 'required|numeric|min:50|max:300',
            'activity_level' => 'required|in:sedentary,light,moderate,active,very_active',
            'goal_type' => 'required|in:lose,maintain,gain',
            'daily_protein' => 'nullable|numeric|min:0|max:1000',
            'daily_carbs' => 'nullable|numeric|min:0|max:1000',
            'daily_fat' => 'nullable|numeric|min:0|max:1000',
        ]);

        $calc = FoodGoal::calculateBmrAndCalories(
            $request->age,
            $request->gender,
            $request->weight,
            $request->height,
            $request->activity_level,
            $request->goal_type
        );

        $goal->update([
            'age' => $request->age,
            'gender' => $request->gender,
            'weight' => $request->weight,
            'height' => $request->height,
            'activity_level' => $request->activity_level,
            'goal_type' => $request->goal_type,
            'bmr' => $calc['bmr'],
            'daily_calories' => $calc['daily_calories'],
            'daily_protein' => $request->daily_protein ?? $calc['daily_calories'] * 0.25 / 4,
            'daily_carbs' => $request->daily_carbs ?? $calc['daily_calories'] * 0.50 / 4,
            'daily_fat' => $request->daily_fat ?? $calc['daily_calories'] * 0.25 / 9,
        ]);

        return redirect()->route('goals.index')->with('success', 'Objectif alimentaire mis à jour avec succès.');
    }

    public function destroy(FoodGoal $goal)
    {
        $goal->delete();
        return redirect()->route('goals.index')->with('success', 'Objectif alimentaire supprimé avec succès.');
    }
}