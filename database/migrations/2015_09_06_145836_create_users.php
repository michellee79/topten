<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table){
            $table->increments('id');
            $table->string('firstName', 20)->nullable();
            $table->string('lastName', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('state', 20)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('loginName', 50)->nullable();
            $table->date('dob')->nullable();
            $table->string('mobilePhone', 20)->nullable();
            $table->string('password', 128)->nullable();
            $table->string('question', 50)->nullable();
            $table->string('answer', 50)->nullable();
            $table->string('passwordSalt', 128)->nullable();
            $table->string('promoCode', 50)->nullable();
            $table->dateTime('createdDate')->nullable();
            $table->tinyInteger('isActivated')->nullable();
            $table->dateTime('activationDate')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->tinyInteger('firstTimeLogin')->nullable();
            $table->tinyInteger('role')->nullable();
            $table->string('remember_token', 100)->nullable();
            $table->integer('promoId')->unsigned();
            $table->integer('franchiseId')->unsigned();
            $table->tinyInteger('inMarketing')->nullable()->default(0);
            $table->tinyInteger('fid')->nullable()->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
