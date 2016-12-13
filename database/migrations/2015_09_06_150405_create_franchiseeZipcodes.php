<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFranchiseeZipcodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('franchiseezipcodes', function(Blueprint $table){
            $table->increments('id');
            $table->integer('franchiseeId')->unsigned();
            $table->integer('zipcodeId')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('franchiseezipcodes');
    }
}
