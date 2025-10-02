<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('age');
            $table->string('gender');
            $table->float('weight');
            $table->float('height');
            $table->string('activity_level');
            $table->float('bmr');
            $table->float('daily_calories');
            $table->float('daily_protein')->nullable();
            $table->float('daily_carbs')->nullable();
            $table->float('daily_fat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_goals');
    }
};