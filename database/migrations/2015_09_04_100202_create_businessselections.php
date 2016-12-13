<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessselections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businessselections', function(Blueprint $table){
            $table->increments('id');
            $table->string('franchiseId', 256)->nullable();
            $table->string('businessName', 256)->nullable();
            $table->string('consumerNominated', 256)->nullable();
            $table->string('businessContact', 256)->nullable();
            $table->string('businessContact2', 256)->nullable();
            $table->string('businessPhone', 256)->nullable();
            $table->string('businessZip', 10)->nullable();
            $table->integer('siteInspection')->nullable();
            $table->integer('interview')->nullable();
            $table->integer('missionStatement')->nullable();
            $table->integer('communityInvolvement')->nullable();
            $table->integer('achievements')->nullable();
            $table->integer('yearsInBusiness')->nullable();
            $table->integer('bbbMembership')->nullable();
            $table->integer('onlineCustomerReviews')->nullable();
            $table->integer('chamberOfCommerce')->nullable();
            $table->integer('passed')->nullable();
            $table->dateTime('dateSubmitted')->nullable();
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
        Schema::drop('businessselections');
    }
}
