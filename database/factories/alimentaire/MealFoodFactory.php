<?php

namespace Database\Factories;

use App\Models\Meal;
use App\Models\Food;
use Illuminate\Database\Eloquent\Factories\Factory;

class MealFoodFactory extends Factory
{
    public function definition(): array
    {
        $food = Food::factory()->create();
        $quantity = $this->faker->randomFloat(2, 1, 5);
        return [
            'meal_id' => Meal::factory(),
            'food_id' => $food->id,
            'quantity' => $quantity,
            'calories_total' => $food->calories * $quantity,
            'protein_total' => $food->protein * $quantity,
            'carbs_total' => $food->carbs * $quantity,
            'fat_total' => $food->fat * $quantity,
        ];
    }
}