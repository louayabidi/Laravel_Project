<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodGoal extends Model
{
    protected $fillable = [
        'user_id',
        'age',
        'gender',
        'weight',
        'height',
        'activity_level',
        'goal_type',
        'bmr',
        'daily_calories',
        'daily_protein',
        'daily_carbs',
        'daily_fat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Calculate BMR and daily calories based on user input and goal type.
     *
     * @param int $age
     * @param string $gender
     * @param float $weight (in kg)
     * @param float $height (in cm)
     * @param string $activity_level
     * @param string $goal_type
     * @return array
     */
    public static function calculateBmrAndCalories($age, $gender, $weight, $height, $activity_level, $goal_type)
    {
        // Mifflin-St Jeor Equation for BMR
        if ($gender === 'male') {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) + 5;
        } else {
            $bmr = (10 * $weight) + (6.25 * $height) - (5 * $age) - 161;
        }

        // Activity level multipliers
        $activity_multipliers = [
            'sedentary' => 1.2,
            'light' => 1.375,
            'moderate' => 1.55,
            'active' => 1.725,
            'very_active' => 1.9,
        ];

        $daily_calories = $bmr * ($activity_multipliers[$activity_level] ?? 1.2);

        // Adjust calories based on goal type
        if ($goal_type === 'lose') {
            $daily_calories *= 0.8; // 20% deficit for weight loss
        } elseif ($goal_type === 'gain') {
            $daily_calories *= 1.2; // 20% surplus for weight gain
        }

        return [
            'bmr' => round($bmr, 2),
            'daily_calories' => round($daily_calories, 2),
        ];
    }
}