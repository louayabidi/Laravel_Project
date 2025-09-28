<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meal_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->cascadeOnDelete();
            $table->foreignId('food_id')->constrained('foods')->cascadeOnDelete(); 
            $table->float('quantity');
            $table->float('calories_total');
            $table->float('protein_total');
            $table->float('carbs_total');
            $table->float('fat_total');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meal_foods');
    }
};