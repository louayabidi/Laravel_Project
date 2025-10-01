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
        Schema::create('sante_mesure', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_mesure');
            $table->decimal('poids_kg', 5, 2);
            $table->decimal('taille_cm', 5, 2);
            $table->integer('freq_cardiaque');
            $table->integer('tension_systolique');
            $table->integer('tension_diastolique');
            $table->text('remarque')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('imc', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sante_mesure');
    }
};
