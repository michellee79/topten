<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateZipcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zipcodes', function(Blueprint $table){
            $table->increments('id');
            $table->string('zipcode', 20)->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->bigInteger('totalUsers')->nullable();
            $table->bigInteger('totalActivatedUsers')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('zipcodes');
    }
}

