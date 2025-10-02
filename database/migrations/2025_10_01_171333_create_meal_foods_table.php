<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('meal_foods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained('meals')->onDelete('cascade');
            $table->foreignId('food_id')->constrained('foods')->onDelete('cascade'); // Changed 'food' to 'foods'
            $table->decimal('quantity', 8, 2);
            $table->decimal('calories_total', 8, 2)->nullable();
            $table->decimal('protein_total', 8, 2)->nullable();
            $table->decimal('carbs_total', 8, 2)->nullable();
            $table->decimal('fat_total', 8, 2)->nullable();
            $table->decimal('sugar_total', 8, 2)->default(0);
            $table->decimal('fiber_total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('meal_foods');
    }
};