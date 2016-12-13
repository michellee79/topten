<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->unsigned()->nullable();
            $table->integer('userId')->unsigned()->nullable();
            $table->text('comment')->nullable();
            $table->integer('rating')->nullable();
            $table->dateTime('submitted_on')->nullable();
            $table->tinyInteger('isResolved')->nullable();
            $table->tinyInteger('isDisplayed')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}

