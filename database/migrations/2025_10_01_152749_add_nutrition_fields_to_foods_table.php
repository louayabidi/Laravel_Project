<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            if (!Schema::hasColumn('foods', 'calories_per_gram')) {
                $table->decimal('calories_per_gram', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('foods', 'protein_per_gram')) {
                $table->decimal('protein_per_gram', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('foods', 'carbs_per_gram')) {
                $table->decimal('carbs_per_gram', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('foods', 'fat_per_gram')) {
                $table->decimal('fat_per_gram', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('foods', 'sugar_per_gram')) {
                $table->decimal('sugar_per_gram', 8, 2)->default(0);
            }
            if (!Schema::hasColumn('foods', 'fiber_per_gram')) {
                $table->decimal('fiber_per_gram', 8, 2)->default(0);
            }
        });
    }

    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $columns = [
                'calories_per_gram',
                'protein_per_gram',
                'carbs_per_gram',
                'fat_per_gram',
                'sugar_per_gram',
                'fiber_per_gram',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('foods', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};