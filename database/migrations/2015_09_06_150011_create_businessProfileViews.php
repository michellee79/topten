<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessProfileViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businessprofileviews', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->unsigned()->nullable();
            $table->string('ip', 50)->nullable();
            $table->dateTime('viewedDate')->nullable();
            $table->integer('userId')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businessprofileviews');
    }
}
