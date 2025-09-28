<?php

namespace Database\Seeders;

use App\Models\Analytic;
use Illuminate\Database\Seeder;

class AnalyticSeeder extends Seeder
{
    public function run(): void
    {
        Analytic::factory(10)->create();
    }
}