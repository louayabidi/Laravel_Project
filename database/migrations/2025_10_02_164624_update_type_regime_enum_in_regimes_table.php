<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change the enum values for type_regime column
        DB::statement("ALTER TABLE regimes MODIFY COLUMN type_regime ENUM('Diabète', 'Hypertension', 'Grossesse', 'Cholestérol élevé (hypercholestérolémie)', 'Maladie cœliaque (intolérance au gluten)', 'Insuffisance rénale')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        DB::statement("ALTER TABLE regimes MODIFY COLUMN type_regime ENUM('Fitnesse', 'musculation', 'prise_de_poids')");
    }
};
