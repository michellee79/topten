<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNominatedbusinesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominatedbusinesses', function(Blueprint $table){
            $table->increments('id');
            $table->string('firstName', 20)->nullable();
            $table->string('lastName', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('businessName', 50)->nullable();
            $table->string('businessCity', 50)->nullable();
            $table->string('businessState', 50)->nullable();
            $table->string('businessPhone', 20)->nullable();
            $table->text('nominationReason')->nullable();
            $table->dateTime('dateSubmitted')->nullable();
            $table->integer('franchiseId')->nullable();
            $table->tinyInteger('isApproved')->nullable();
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
        Schema::drop('nominatedbusinesses');
    }
}
