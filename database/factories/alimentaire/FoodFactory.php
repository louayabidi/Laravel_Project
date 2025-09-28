<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FoodFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'category' => $this->faker->word,
            'calories' => $this->faker->randomFloat(2, 50, 500),
            'protein' => $this->faker->randomFloat(2, 0, 50),
            'carbs' => $this->faker->randomFloat(2, 0, 100),
            'fat' => $this->faker->randomFloat(2, 0, 50),
            'sugar' => $this->faker->randomFloat(2, 0, 20),
            'fiber' => $this->faker->randomFloat(2, 0, 10),
            'is_custom' => $this->faker->boolean,
        ];
    }
}