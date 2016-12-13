<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUscities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uscities', function(Blueprint $table){
            $table->increments('id');
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('stateAbbr', 50)->nullable();
            $table->string('zipCode', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('uscities');
    }
}
