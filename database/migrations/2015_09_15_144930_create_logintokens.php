<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogintokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logintokens', function(Blueprint $table){
            $table->increments('id');
            $table->integer('userId')->nullable();
            $table->string('token', 32)->nullable();
            $table->string('latitude', 16)->nullable();
            $table->string('longitude', 16)->nullable();
            $table->dateTime('lastSeen')->nullable();
            $table->tinyInteger('devType')->nullable();
            $table->string('devToken', 4096)->nullable();
            $table->string('zipcode', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('logintokens');
    }
}
