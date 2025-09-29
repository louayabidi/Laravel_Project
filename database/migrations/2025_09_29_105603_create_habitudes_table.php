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
        Schema::create('habitudes', function (Blueprint $table) {
        $table->id('habitude_id');
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // si tu veux lier aux utilisateurs
        $table->date('date_jour');
        $table->float('sommeil_heures')->nullable();
        $table->float('eau_litres')->nullable();
        $table->integer('sport_minutes')->nullable();
        $table->integer('stress_niveau')->nullable();
        $table->integer('meditation_minutes')->nullable();
        $table->integer('temps_ecran_minutes')->nullable();
        $table->integer('cafe_cups')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('habitudes');
    }
};
