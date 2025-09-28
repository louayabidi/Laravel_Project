<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MealFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => 1, // Static
            'type' => $this->faker->randomElement(['breakfast', 'lunch', 'dinner', 'snack']),
            'date' => $this->faker->date,
        ];
    }
}