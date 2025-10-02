<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
public function up()
{
Schema::create('likes', function (Blueprint $table) {
$table->id();
$table->foreignId('user_id')->constrained()->onDelete('cascade');
$table->foreignId('post_id')->nullable()->constrained('posts')->onDelete('cascade');
$table->foreignId('comment_id')->nullable()->constrained('comments')->onDelete('cascade');
$table->timestamps();


$table->unique(['user_id','post_id','comment_id'], 'likes_unique_target');
});
}


public function down()
{
Schema::dropIfExists('likes');
}
};