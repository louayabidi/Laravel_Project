<?php

namespace App\Http\Controllers;

use App\Models\FoodGoal;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
            'is_active' => 'boolean',
        ]);

        $calc = FoodGoal::calculateBmrAndCalories(
            $request->age,
            $request->gender,
            $request->weight,
            $request->height,
            $request->activity_level,
            $request->goal_type
        );

        $goal = FoodGoal::create([
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
            'is_active' => $request->input('is_active', true),
        ]);

        try {
            if ($goal->is_active) {
                $goal->setAsActive();
            }

            // Log yetsagel lina
            ActivityLog::create([
                'user_id' => $goal->user_id,
                'action' => 'created_food_goal',
                'description' => 'Utilisateur a créé un nouvel objectif alimentaire : ' . ucfirst($goal->goal_type == 'lose' ? 'Perdre du poids' : ($goal->goal_type == 'maintain' ? 'Maintenir le poids' : 'Prendre du poids')),
                'details' => [
                    'goal_id' => $goal->id,
                    'goal_type' => $goal->goal_type,
                    'daily_calories' => $goal->daily_calories,
                    'daily_protein' => $goal->daily_protein,
                    'daily_carbs' => $goal->daily_carbs,
                    'daily_fat' => $goal->daily_fat,
                ],
            ]);

            return redirect()->route('goals.index')->with('success', 'Objectif alimentaire créé avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to set active goal or log activity: ' . $e->getMessage());
            return redirect()->route('goals.index')->with('error', 'Erreur lors de la création de l\'objectif ou de l\'enregistrement de l\'activité.');
        }
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
            'is_active' => 'boolean',
        ]);

        $calc = FoodGoal::calculateBmrAndCalories(
            $request->age,
            $request->gender,
            $request->weight,
            $request->height,
            $request->activity_level,
            $request->goal_type
        );

        $wasActive = $goal->is_active;
        $newIsActive = $request->input('is_active', false);

        try {
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
                'is_active' => $newIsActive,
            ]);

            if ($wasActive && !$newIsActive) {
                $newActiveGoal = FoodGoal::where('user_id', $goal->user_id)
                    ->where('id', '!=', $goal->id)
                    ->latest()
                    ->first();
                if ($newActiveGoal) {
                    $newActiveGoal->setAsActive();
                }
            } elseif ($newIsActive) {
                $goal->setAsActive();
            }

            return redirect()->route('goals.index')->with('success', 'Objectif alimentaire mis à jour avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to update goal: ' . $e->getMessage());
            return redirect()->route('goals.index')->with('error', 'Erreur lors de la mise à jour de l\'objectif.');
        }
    }

    public function destroy(FoodGoal $goal)
    {
        try {
            if ($goal->is_active) {
                $newActiveGoal = FoodGoal::where('user_id', $goal->user_id)
                    ->where('id', '!=', $goal->id)
                    ->latest()
                    ->first();
                if ($newActiveGoal) {
                    $newActiveGoal->setAsActive();
                }
            }

            $goal->delete();
            return redirect()->route('goals.index')->with('success', 'Objectif alimentaire supprimé avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to delete goal: ' . $e->getMessage());
            return redirect()->route('goals.index')->with('error', 'Erreur lors de la suppression de l\'objectif.');
        }
    }

    public function setActive(FoodGoal $goal)
    {
        try {
            $goal->setAsActive();
            return redirect()->route('goals.index')->with('success', 'Objectif alimentaire activé avec succès.');
        } catch (\Exception $e) {
            Log::error('Failed to set active goal: ' . $e->getMessage());
            return redirect()->route('goals.index')->with('error', 'Erreur lors de l\'activation de l\'objectif.');
        }
    }
public function activityLogs()
{
    try {
        $logs = ActivityLog::with('user')->latest()->paginate(10);

        return view('alimentaire.activity_logs.index', compact('logs'))
            ->with('activePage', 'activity_logs');
    } catch (\Exception $e) {
        Log::error('Failed to fetch activity logs: ' . $e->getMessage());
        return redirect()->route('dashboard')->with('error', 'Erreur lors du chargement du journal d\'activités.');
    }
}

}