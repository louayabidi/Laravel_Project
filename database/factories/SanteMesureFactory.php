<?php

namespace Database\Factories;

use App\Models\SanteMesure;
use Illuminate\Database\Eloquent\Factories\Factory;

class SanteMesureFactory extends Factory
{
    protected $model = SanteMesure::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'date_mesure' => $this->faker->date(),
            'date_remplie' => $this->faker->date(),
            'poids_kg' => $this->faker->randomFloat(2, 20, 150),
            'taille_cm' => $this->faker->numberBetween(140, 210),
            'freq_cardiaque' => $this->faker->numberBetween(40, 120),
            'tension_systolique' => $this->faker->numberBetween(90, 140),
            'tension_diastolique' => $this->faker->numberBetween(60, 90),
            'remarque' => $this->faker->sentence(),
            'regime_id' => \App\Models\Regime::factory(),
            'imc' => $this->faker->randomFloat(2, 15, 40),
        ];
    }
}
