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
        // Ajout de la colonne objectif_id dans habitudes
        Schema::table('habitudes', function (Blueprint $table) {
            $table->foreignId('objectif_id')
                  ->nullable()
                  ->constrained('objectifs')
                  ->onDelete('set null');
        });

        // Ajout de la colonne user_id dans objectifs
        Schema::table('objectifs', function (Blueprint $table) {
            $table->foreignId('user_id')
                  ->after('id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('habitudes', function (Blueprint $table) {
            $table->dropForeign(['objectif_id']);
            $table->dropColumn('objectif_id');
        });

        Schema::table('objectifs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
