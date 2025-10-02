<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            // Make nutrition fields nullable
            if (Schema::hasColumn('foods', 'calories')) {
                $table->decimal('calories', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'protein')) {
                $table->decimal('protein', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'carbs')) {
                $table->decimal('carbs', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'fat')) {
                $table->decimal('fat', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'sugar')) {
                $table->decimal('sugar', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'fiber')) {
                $table->decimal('fiber', 8, 2)->nullable()->change();
            }
            if (Schema::hasColumn('foods', 'category')) {
                $table->string('category')->nullable()->change();
            }
        });
    }

    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            // Revert to not nullable (optional, adjust based on needs)
            if (Schema::hasColumn('foods', 'calories')) {
                $table->decimal('calories', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'protein')) {
                $table->decimal('protein', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'carbs')) {
                $table->decimal('carbs', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'fat')) {
                $table->decimal('fat', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'sugar')) {
                $table->decimal('sugar', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'fiber')) {
                $table->decimal('fiber', 8, 2)->nullable(false)->change();
            }
            if (Schema::hasColumn('foods', 'category')) {
                $table->string('category')->nullable(false)->change();
            }
        });
    }
};