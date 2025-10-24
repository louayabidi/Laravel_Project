<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\BadgeGoal;
use Illuminate\Http\Request;

class BadgeGoalController extends Controller
{
    public function store(Request $request, Badge $badge)
    {
        $validated = $request->validate([
            'goals.*.field' => 'required|in:sommeil_heures,eau_litres,sport_minutes,stress_niveau,meditation_minutes,temps_ecran_minutes,cafe_cups,calories,protein,carbs,fat,sugar,fiber',
            'goals.*.comparison' => 'required|in:>=,<=',
            'goals.*.value' => 'required|numeric|min:0',
            'goals.*.points' => 'required|integer|min:0',
        ]);

        foreach ($validated['goals'] as $goalData) {
            $badge->goals()->create($goalData);
        }

        return back()->with('success', 'Goals added successfully!');
    }
}
