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
        Schema::create('regimes', function (Blueprint $table) {
            $table->id();
            $table->enum('type_regime', ['Fitnesse', 'musculation', 'prise_de_poids']);
            $table->decimal('valeur_cible', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('regimes');
    }
};
