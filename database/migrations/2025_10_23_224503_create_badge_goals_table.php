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
        Schema::create('badge_goals', function (Blueprint $table) {
    $table->id();
    $table->foreignId('badge_id')->constrained()->onDelete('cascade');
    $table->enum('field', [
        'sommeil_heures',
        'eau_litres',
        'sport_minutes',
        'stress_niveau',
        'meditation_minutes',
        'temps_ecran_minutes',
        'cafe_cups',
        'calories',
        'protein',
        'carbs',
        'fat',
        'sugar',
        'fiber'
    ]);
    $table->enum('comparison', ['>=', '<='])->default('>=');
    $table->float('value'); // the goal target value
    $table->integer('points')->default(10); // optional: points for this goal
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_goals');
    }
};
