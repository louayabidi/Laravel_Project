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
        // Drop extra custom tables if they exist
        Schema::dropIfExists('type_regime');
        Schema::dropIfExists('fitnesses');
        Schema::dropIfExists('musculations');
        Schema::dropIfExists('prise_de_poids');

        // Clean any denormalized fields if still present in users (though rollback should have handled)
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'regime_id')) $table->dropColumn('regime_id');
            if (Schema::hasColumn('users', 'type_regime')) $table->dropColumn('type_regime');
            if (Schema::hasColumn('users', 'valeur_cible')) $table->dropColumn('valeur_cible');
            if (Schema::hasColumn('users', 'description')) $table->dropColumn('description');
        });

        // Clean sante_mesure if old fields remain
        Schema::table('sante_mesure', function (Blueprint $table) {
            if (Schema::hasColumn('sante_mesure', 'type_regime')) $table->dropColumn('type_regime');
            if (Schema::hasColumn('sante_mesure', 'valeur_cible')) $table->dropColumn('valeur_cible');
            if (Schema::hasColumn('sante_mesure', 'description')) $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to reverse for cleanup
    }
};
