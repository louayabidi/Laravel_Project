<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('food_goals', function (Blueprint $table) {
            $table->string('goal_type')->nullable()->after('activity_level');
        });
    }

    public function down()
    {
        Schema::table('food_goals', function (Blueprint $table) {
            $table->dropColumn('goal_type');
        });
    }
};