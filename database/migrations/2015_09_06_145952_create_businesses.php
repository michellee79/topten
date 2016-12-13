<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 256)->nullable();
            $table->integer('subCatId')->unsigned()->nullable();
            $table->integer('subCatId2')->unsigned()->nullable();
            $table->string('address', 256)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zipcode', 50)->nullable();
            $table->string('firstName', 50)->nullable();
            $table->string('lastName', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website', 256)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('cellPhone', 50)->nullable();
            $table->dateTime('dateCreated')->nullable();
            $table->dateTime('startDate')->nullable();
            $table->double('latitude', 15, 8)->nullable();
            $table->double('longitude', 15, 8)->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->text('profileTopLeft')->nullable();
            $table->text('profileTopRight')->nullable();
            $table->text('profileBottomLeft')->nullable();
            $table->text('summary')->nullable();
            $table->integer('logoId')->unsigned()->nullable();
            $table->integer('createdBy')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businesses');
    }
}
