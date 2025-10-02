<?php

namespace App\Http\Controllers;

use App\Models\FoodGoal;
use App\Models\Meal;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        $userId = auth()->id() ?? 1;
        
        // Get the active food goal for the user
        $goal = FoodGoal::where('user_id', $userId)->where('is_active', true)->first();
        
        if (!$goal) {
            return redirect()->route('goals.create')->with('error', 'Aucun objectif alimentaire actif n\'est défini. Veuillez en créer un ou activer un objectif existant.');
        }
        
        // Get today's date
        $today = now()->format('Y-m-d');
        
        // Get all meals for today
        $meals = Meal::where('user_id', $userId)->where('date', $today)->get();
        
        // Initialize daily totals
        $dailyTotals = [
            'calories' => 0,
            'protein' => 0,
            'carbs' => 0,
            'fat' => 0,
            'sugar' => 0,
            'fiber' => 0,
        ];
        
        // Sum up totals from all meals
        foreach ($meals as $meal) {
            $totals = $meal->getTotals();
            foreach ($dailyTotals as $key => &$value) {
                $value += $totals[$key];
            }
        }
        
        // Calculate remaining macros
        $remaining = [
            'calories' => $goal->daily_calories - $dailyTotals['calories'],
            'protein' => $goal->daily_protein - $dailyTotals['protein'],
            'carbs' => $goal->daily_carbs - $dailyTotals['carbs'],
            'fat' => $goal->daily_fat - $dailyTotals['fat'],
        ];
        
        // Generate feedback messages based on goal_type
        $messages = [];
        
        // Calories feedback
        $calorie_message = '';
        if ($goal->goal_type === 'lose') {
            if ($remaining['calories'] <= 0) {
                $calorie_message = 'Vous avez dépassé votre objectif de perte de poids de ' . abs($remaining['calories']) . ' calories. Essayez de réduire votre apport calorique.';
            } elseif ($remaining['calories'] < 200) {
                $calorie_message = 'Vous êtes très proche de votre objectif de perte de poids. Il reste seulement ' . $remaining['calories'] . ' calories.';
            } elseif ($remaining['calories'] < 500) {
                $calorie_message = 'Vous êtes proche de votre objectif de perte de poids. Il reste ' . $remaining['calories'] . ' calories.';
            } else {
                $calorie_message = 'Vous êtes en bonne voie pour perdre du poids, mais il reste ' . $remaining['calories'] . ' calories à consommer.';
            }
        } elseif ($goal->goal_type === 'gain') {
            if ($remaining['calories'] <= 0) {
                $calorie_message = 'Excellent ! Vous avez atteint ou dépassé votre objectif de prise de poids de ' . abs($remaining['calories']) . ' calories.';
            } elseif ($remaining['calories'] < 200) {
                $calorie_message = 'Vous êtes très proche de votre objectif de prise de poids. Il reste seulement ' . $remaining['calories'] . ' calories.';
            } elseif ($remaining['calories'] < 500) {
                $calorie_message = 'Vous êtes proche de votre objectif de prise de poids. Il reste ' . $remaining['calories'] . ' calories.';
            } else {
                $calorie_message = 'Pour atteindre votre objectif de prise de poids, consommez encore ' . $remaining['calories'] . ' calories.';
            }
        } else { // maintain
            if ($remaining['calories'] <= 0) {
                $calorie_message = 'Vous avez dépassé votre objectif de maintien de poids de ' . abs($remaining['calories']) . ' calories.';
            } elseif ($remaining['calories'] < 200) {
                $calorie_message = 'Vous êtes très proche de votre objectif de maintien de poids. Il reste seulement ' . $remaining['calories'] . ' calories.';
            } elseif ($remaining['calories'] < 500) {
                $calorie_message = 'Vous êtes proche de votre objectif de maintien de poids. Il reste ' . $remaining['calories'] . ' calories.';
            } else {
                $calorie_message = 'Pour maintenir votre poids, consommez encore ' . $remaining['calories'] . ' calories.';
            }
        }
        $messages['calories'] = $calorie_message;

        // Protein feedback (adjust for goal_type if needed)
        if ($remaining['protein'] <= 0) {
            $messages['protein'] = 'Vous avez dépassé votre objectif quotidien en protéines de ' . abs($remaining['protein']) . ' g.';
        } elseif ($remaining['protein'] < 20) {
            $messages['protein'] = 'Vous êtes très proche de votre objectif quotidien en protéines. Il reste seulement ' . $remaining['protein'] . ' g.';
        } elseif ($remaining['protein'] < 50) {
            $messages['protein'] = 'Vous êtes proche de votre objectif quotidien en protéines. Il reste ' . $remaining['protein'] . ' g.';
        } else {
            $messages['protein'] = 'Il vous reste beaucoup à faire pour les protéines. Il reste ' . $remaining['protein'] . ' g.';
        }
        
        // Carbs feedback
        if ($remaining['carbs'] <= 0) {
            $messages['carbs'] = 'Vous avez dépassé votre objectif quotidien en glucides de ' . abs($remaining['carbs']) . ' g.';
        } elseif ($remaining['carbs'] < 50) {
            $messages['carbs'] = 'Vous êtes très proche de votre objectif quotidien en glucides. Il reste seulement ' . $remaining['carbs'] . ' g.';
        } elseif ($remaining['carbs'] < 100) {
            $messages['carbs'] = 'Vous êtes proche de votre objectif quotidien en glucides. Il reste ' . $remaining['carbs'] . ' g.';
        } else {
            $messages['carbs'] = 'Il vous reste beaucoup à faire pour les glucides. Il reste ' . $remaining['carbs'] . ' g.';
        }
        
        // Fat feedback
        if ($remaining['fat'] <= 0) {
            $messages['fat'] = 'Vous avez dépassé votre objectif quotidien en lipides de ' . abs($remaining['fat']) . ' g.';
        } elseif ($remaining['fat'] < 20) {
            $messages['fat'] = 'Vous êtes très proche de votre objectif quotidien en lipides. Il reste seulement ' . $remaining['fat'] . ' g.';
        } elseif ($remaining['fat'] < 50) {
            $messages['fat'] = 'Vous êtes proche de votre objectif quotidien en lipides. Il reste ' . $remaining['fat'] . ' g.';
        } else {
            $messages['fat'] = 'Il vous reste beaucoup à faire pour les lipides. Il reste ' . $remaining['fat'] . ' g.';
        }
        
        return view('alimentaire.tracking.index', compact('goal', 'dailyTotals', 'remaining', 'messages', 'meals'));
    }
}
