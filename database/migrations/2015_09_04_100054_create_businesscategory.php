<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinesscategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesscategory', function(Blueprint $table){
            $table->increments('id');
            $table->string('ctGroup', 256)->nullable();
            $table->string('category', 256)->nullable();
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
        Schema::drop('businesscategory');
    }
}
