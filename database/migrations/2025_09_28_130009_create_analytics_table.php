<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('analytics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Static for now
            $table->float('daily_calories')->nullable();
            $table->float('protein');
            $table->float('carbs');
            $table->float('fat');
            $table->date('week_start');
            $table->date('week_end');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analytics');
    }
};