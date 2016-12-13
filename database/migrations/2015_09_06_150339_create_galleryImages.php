<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleryimages', function(Blueprint $table){
            $table->increments('id');
            $table->string('category', 50)->nullable();
            $table->string('url', 256)->nullable();
            $table->dateTime('added')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('galleryimages');
    }
}
