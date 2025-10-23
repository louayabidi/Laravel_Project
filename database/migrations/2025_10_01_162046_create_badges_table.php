<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1) Badge Categories Table
        Schema::create('badge_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->timestamps();
        });

        // 2) Badges Table
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('criteria')->nullable();
            $table->foreignId('badge_categorie_id')
                  ->constrained('badge_categories')
                  ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Drop badges first because it depends on badge_categories
        Schema::dropIfExists('badges');
        Schema::dropIfExists('badge_categories');
    }
};
