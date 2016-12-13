<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businessimages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->unsigned();
            $table->integer('imageId')->unsigned();
            $table->integer('imageOrder')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businessimages');
    }
}
