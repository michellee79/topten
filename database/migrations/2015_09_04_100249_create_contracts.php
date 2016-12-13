<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function(Blueprint $table){
            $table->increments('id');
            $table->string('title', 50)->nullable();
            $table->dateTime('createdDate')->nullable();
            $table->dateTime('lastUpdated')->nullable();
            $table->tinyInteger('isActive')->nullable();
            $table->text('content')->nullable();
            $table->string('enterprise', 50)->nullable();
            $table->string('corporation', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('contracts');
    }
}
