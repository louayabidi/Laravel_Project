<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('sante_mesure', function (Blueprint $table) {
            // Augmenter la taille de la colonne imc de decimal(4,2) à decimal(5,2)
            $table->decimal('imc', 5, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('sante_mesure', function (Blueprint $table) {
            $table->decimal('imc', 4, 2)->nullable()->change();
        });
    }
};
