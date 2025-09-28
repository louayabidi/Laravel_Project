<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@material.com',
            'password' => ('secret')
        ]);




        $this->call(FoodSeeder::class);
        $this->call(MealSeeder::class);
        $this->call(AnalyticSeeder::class);
        $this->call(MealFoodSeeder::class);
    }
}
