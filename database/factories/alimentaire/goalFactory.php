<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class GoalFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'age' => $this->faker->numberBetween(18, 60),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'weight' => $this->faker->randomFloat(1, 50, 100),
            'height' => $this->faker->randomFloat(1, 150, 200),
            'activity_level' => $this->faker->randomElement(['sedentary', 'light', 'moderate', 'active', 'very_active']),
            'bmr' => $this->faker->randomFloat(1, 1000, 2000),
            'daily_calories' => $this->faker->randomFloat(1, 1500, 3000),
            'daily_protein' => $this->faker->randomFloat(1, 50, 200),
            'daily_carbs' => $this->faker->randomFloat(1, 100, 400),
            'daily_fat' => $this->faker->randomFloat(1, 50, 150),
        ];
    }
}