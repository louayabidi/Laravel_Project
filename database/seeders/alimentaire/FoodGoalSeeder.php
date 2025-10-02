<?php

namespace Database\Seeders;

use App\Models\FoodGoal;
use Illuminate\Database\Seeder;

class FoodGoalSeeder extends Seeder
{
    public function run(): void
    {
        $goals = [
            [
                'user_id' => 1,
                'age' => 30,
                'gender' => 'male',
                'weight' => 80,
                'height' => 175,
                'activity_level' => 'moderate',
            ],
            [
                'user_id' => 1,
                'age' => 25,
                'gender' => 'female',
                'weight' => 60,
                'height' => 165,
                'activity_level' => 'light',
            ],
        ];

        foreach ($goals as $goalData) {
            $calc = FoodGoal::calculateBmrAndCalories(
                $goalData['age'],
                $goalData['gender'],
                $goalData['weight'],
                $goalData['height'],
                $goalData['activity_level']
            );

            FoodGoal::create([
                'user_id' => $goalData['user_id'],
                'age' => $goalData['age'],
                'gender' => $goalData['gender'],
                'weight' => $goalData['weight'],
                'height' => $goalData['height'],
                'activity_level' => $goalData['activity_level'],
                'bmr' => $calc['bmr'],
                'daily_calories' => $calc['daily_calories'],
                'daily_protein' => $calc['daily_calories'] * 0.25 / 4,
                'daily_carbs' => $calc['daily_calories'] * 0.50 / 4,
                'daily_fat' => $calc['daily_calories'] * 0.25 / 9,
            ]);
        }
    }
}