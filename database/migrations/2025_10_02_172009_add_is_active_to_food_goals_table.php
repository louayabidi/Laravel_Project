<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToFoodGoalsTable extends Migration
{
    public function up()
    {
        Schema::table('food_goals', function (Blueprint $table) {
            $table->boolean('is_active')->default(false);
        });
    }

    public function down()
    {
        Schema::table('food_goals', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
}