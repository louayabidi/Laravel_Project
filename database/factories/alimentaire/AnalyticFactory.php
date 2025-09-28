<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnalyticFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1, // Static
            'daily_calories' => $this->faker->randomFloat(2, 1000, 3000),
            'protein' => $this->faker->randomFloat(2, 50, 200),
            'carbs' => $this->faker->randomFloat(2, 100, 400),
            'fat' => $this->faker->randomFloat(2, 50, 150),
            'week_start' => $this->faker->date,
            'week_end' => $this->faker->date('Y-m-d', '+7 days'),
        ];
    }
}