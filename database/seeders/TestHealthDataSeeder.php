<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SanteMesure;
use Carbon\Carbon;

class TestHealthDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create test user if not exists
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'user'
            ]
        );

        // Create a test regime first
        $regime = \App\Models\Regime::firstOrCreate(
            ['type_regime' => 'Diabète'],
            [
                'valeur_cible' => 75,
                'description' => 'Régime de test pour IA'
            ]
        );

        // Create 31 days of health measurements with trends that will trigger AI alerts
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            // Create gradual trends that will trigger alerts
            $weight = 75 + ($i * 0.2); // Gradual weight increase
            $systolic = 120 + ($i * 0.5); // Gradual BP increase (will exceed 140)
            $diastolic = 80 + ($i * 0.3); // Gradual BP increase (will exceed 90)
            $heartRate = 70 + ($i * 0.2); // Gradual heart rate increase

            SanteMesure::create([
                'user_id' => $user->id,
                'regime_id' => $regime->id,
                'date_mesure' => $date,
                'poids_kg' => $weight,
                'taille_cm' => 175,
                'freq_cardiaque' => $heartRate,
                'tension_systolique' => $systolic,
                'tension_diastolique' => $diastolic,
                'imc' => $weight / (1.75 * 1.75),
                'remarque' => 'Mesure automatique pour test IA'
            ]);
        }

        $this->command->info('Created test user and 31 health measurements for AI testing');
    }
}
