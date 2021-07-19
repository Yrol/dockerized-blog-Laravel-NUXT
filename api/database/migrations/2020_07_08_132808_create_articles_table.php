<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('body');
            $table->longText('description');
            $table->string('slug'); //slug is the SEO friendly URL spaces replaces by hyphens. ex: test.com/how-are-you. Laravel has in-built generator - str_slug($string)
            $table->string('tags')->nullable();
            $table->boolean('is_live')->default(false);//allow publish and unpublish
            $table->boolean('close_to_comment')->default(false); // allow users to comment
            $table->timestamps();

            //Dependencies
            // "Unsigned numbers can only be positive or zero"
            $table->bigInteger('user_id')->unsigned(); //ID of the user who created the Article
            $table->foreign('user_id')->references('id')->on('users');

            $table->bigInteger('category_id')->unsigned(); // ID of the category which the article belongs to
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
