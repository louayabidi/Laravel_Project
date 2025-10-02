<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('habitudes', function (Blueprint $table) {
        $table->dropForeign(['user_id']); // supprime la FK
        $table->dropColumn('user_id');   // supprime la colonne
    });
}


    public function down(): void
{
    Schema::table('habitudes', function (Blueprint $table) {
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    });
}

};
