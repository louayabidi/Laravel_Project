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
        Schema::create('objectifs', function (Blueprint $table) {
        $table->id(); // objectif_id
        $table->string('title');
        $table->text('description')->nullable();
        $table->integer('target_value');
        $table->date('start_date');
        $table->date('end_date');
        $table->enum('status', ['Sommeil', 'Eau', 'Sport', 'Stress'])->default('Sommeil');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objectifs');
    }
};
