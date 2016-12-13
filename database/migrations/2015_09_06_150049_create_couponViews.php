<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('couponviews', function(Blueprint $table){
            $table->increments('id');
            $table->integer('couponId')->unsigned()->nullable();
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
        Schema::drop('couponviews');
    }
}
