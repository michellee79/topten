<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchisees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchisees', function(Blueprint $table){
            $table->increments('id');
            $table->integer('userId')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('contactFirstName', 50)->nullable();
            $table->string('contactLastName', 50)->nullable();
            $table->string('contactEmail', 50)->nullable();
            $table->dateTime('created')->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->tinyInteger('isLaunched')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->string('legalName', 50)->nullable();
            $table->string('streetAddress', 128)->nullable();
            $table->tinyInteger('showOnContract')->nullable();
            $table->string('franchiseZipcode', 10)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('lmGroup', 20)->nullable();
            $table->string('lmUser', 50)->nullable();
            $table->string('lmPassword', 128)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('franchisees');
    }
}
