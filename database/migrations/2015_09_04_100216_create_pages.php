<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function(Blueprint $table){
            $table->increments('id');
            $table->integer('parentId')->nullable();
            $table->string('pageName', 256)->nullable();
            $table->text('metaKeywords')->nullable();
            $table->text('metaDescription')->nullable();
            $table->text('pageContent')->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->dateTime('createdDate')->nullable();
            $table->dateTime('lastUpdated')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}
