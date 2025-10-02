<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            // Make category nullable
            $table->string('category')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            // Revert to not nullable (optional, adjust based on your needs)
            $table->string('category')->nullable(false)->change();
        });
    }
};