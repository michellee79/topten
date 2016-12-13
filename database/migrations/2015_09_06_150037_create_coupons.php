<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoupons extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->nullable();
            $table->string('title', 256)->nullable();
            $table->text('description')->nullable();
            $table->string('altDescription', 256)->nullable();
            $table->float('discount')->nullable();
            $table->float('averageValue')->nullable();
            $table->text('disclaimer')->nullable();
            $table->integer('clicks')->nullable();
            $table->string('imageUrl', 256)->nullable();
            $table->dateTime('dateCreated')->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->string('couponValueText', 256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('coupons');
    }
}
