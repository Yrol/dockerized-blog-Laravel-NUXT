<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->morphs('likable');

            //dependencies
            // "Unsigned numbers can only be positive or zero"
            $table->bigInteger('user_id')->unsigned();// ID of the user who liked
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');//delete like data when user get removed from the system
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
