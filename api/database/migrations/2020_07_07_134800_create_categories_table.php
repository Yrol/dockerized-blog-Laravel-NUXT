<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('slug'); //slug is the SEO friendly URL spaces replaces by hyphens. ex: test.com/how-are-you. Laravel has in-built generator - str_slug($string)

            //Dependencies
            // "Unsigned numbers can only be positive or zero"
            $table->bigInteger('user_id')->unsigned(); //ID of the user who created the Article
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
