<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meal_foods', function (Blueprint $table) {
            $table->string('name')->nullable()->after('food_id'); // For AI-recognized label override
            $table->boolean('recognized_by_ai')->default(false)->after('name'); // Flag for AI-added entries
        });
    }

    public function down(): void
    {
        Schema::table('meal_foods', function (Blueprint $table) {
            $table->dropColumn(['name', 'recognized_by_ai']);
        });
    }
};