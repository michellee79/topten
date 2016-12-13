<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function(Blueprint $table){
            $table->increments('id');
            $table->string('code', 20)->nullable();
            $table->dateTime('created')->nullable();
            $table->string('assignedTo', 50)->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->tinyInteger('requireActivation')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->integer('totalSignedUp')->nullable();
            $table->integer('totalActivated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promos');
    }
}
