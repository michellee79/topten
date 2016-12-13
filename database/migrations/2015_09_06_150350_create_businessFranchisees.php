<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessFranchisees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businessfranchisees', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->unsigned();
            $table->integer('franchiseeId')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businessfranchisees');
    }
}
