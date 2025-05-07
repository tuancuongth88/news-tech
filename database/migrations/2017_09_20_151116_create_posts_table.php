<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',150);
            $table->text('content');
            $table->mediumText('description');
            $table->string('slug')->unique();
            $table->integer('view')->default(1);
            $table->string('post_type')->default('text');
            $table->smallInteger('hot')->default(0);
            $table->smallInteger('status')->default(1);
            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('admin')->onDelete('cascade');

            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
