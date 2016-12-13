<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaints extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaints', function(Blueprint $table){
            $table->increments('id');
            $table->integer('businessId')->nullable();
            $table->integer('userId')->unsigned()->nullable();
            $table->text('comment')->nullable();
            $table->integer('rating')->nullable();
            $table->timestamp('submitted_on')->nullable();
            $table->timestamp('emailed_on')->nullable();
            $table->tinyInteger('isPublished')->default(0);
            $table->tinyInteger('isResolved')->default(0);
            $table->tinyInteger('isDeleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('complaints');
    }
}
