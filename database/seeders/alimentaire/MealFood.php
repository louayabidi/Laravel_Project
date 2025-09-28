<?php

namespace Database\Seeders;

use App\Models\MealFood;
use Illuminate\Database\Seeder;

class MealFoodSeeder extends Seeder
{
    public function run(): void
    {
        MealFood::factory(10)->create();
    }
}