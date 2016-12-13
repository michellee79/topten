<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessSubCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesssubcategories', function(Blueprint $table){
            $table->increments('id');
            $table->integer('parentCategoryId')->nullable();
            $table->string('subCategory')->nullable();
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
        Schema::drop('businesssubcategories');
    }
}
