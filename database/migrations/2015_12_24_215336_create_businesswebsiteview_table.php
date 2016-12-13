<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinesswebsiteviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesswebsiteview', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->unsigned()->nullable();
            $table->string('ip', 50)->nullable();
            $table->dateTime('viewedDate')->nullable();
            $table->integer('userId')->nullable();
        });
        Schema::table('businesswebsiteview', function($table){
            $table->foreign('businessId')->references('id')->on('businesses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesswebsiteview', function($table){
            $table->dropForeign('businesswebsiteview_businessid_foreign');
        });
        Schema::drop('businesswebsiteview');
    }
}
