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
        Schema::table('badge_user', function (Blueprint $table) {
            $table->integer('total_points')->default(0)->after('badge_id');
            $table->boolean('acquired')->default(false)->after('total_points');
        });
    }

    public function down(): void
    {
        Schema::table('badge_user', function (Blueprint $table) {
            $table->dropColumn(['total_points', 'acquired']);
        });
    }

};
