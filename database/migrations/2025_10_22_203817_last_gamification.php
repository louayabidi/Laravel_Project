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
        // Badge categories
        if (!Schema::hasTable('badge_categories')) {
            Schema::create('badge_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('icon')->nullable();
                $table->timestamps();
            });
        }

        // Badges
        if (!Schema::hasTable('badges')) {
            Schema::create('badges', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('title')->nullable();
                $table->text('description')->nullable();
                $table->string('image')->nullable();
                $table->string('criteria')->nullable();
                $table->foreignId('badge_categorie_id')
                    ->constrained('badge_categories')
                    ->onDelete('cascade');
                $table->timestamps();
            });
        }

        // Pivot table badge_user
        if (!Schema::hasTable('badge_user')) {
            Schema::create('badge_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('badge_id')->constrained()->onDelete('cascade');
                $table->integer('total_points')->default(0);
                $table->boolean('acquired')->default(false);
                $table->timestamps();

                // Prevent duplicate badges for the same user
                $table->unique(['user_id', 'badge_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badge_user');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('badge_categories');
    }
};
