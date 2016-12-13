<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinesscontracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesscontracts', function(Blueprint $table){
            $table->increments('id');
            $table->string('contractId', 50)->nullable();
            $table->integer('businessId')->nullable();
            $table->string('name', 256)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website', 256)->nullable();
            $table->dateTime('effectiveDate')->nullable();
            $table->string('address', 256)->nullable();
            $table->string('city', 50)->nullable();
            $table->string('state', 50)->nullable();
            $table->string('zip', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('authorizedRep', 50)->nullable();
            $table->string('repTitle', 50)->nullable();
            $table->integer('subCatId')->nullable();
            $table->integer('subCatId2')->nullable();
            $table->text('additionalInstructions')->nullable();
            $table->string('initialCoupon', 256)->nullable();
            $table->string('averageTransaction', 256)->nullable();
            $table->string('averageDeterminedValue', 256)->nullable();
            $table->dateTime('visibleOnWebsite')->nullable();
            $table->dateTime('paymentDueDate')->nullable();
            $table->string('paymentType', 50)->nullable();
            $table->string('membershipType', 50)->nullable();
            $table->float('membershipFee')->nullable();
            $table->string('initialFeeType', 50)->nullable();
            $table->float('fee')->nullable();
            $table->string('other1', 256)->nullable();
            $table->string('other2', 256)->nullable();
            $table->text('note')->nullable();
            $table->float('totalDueNow')->nullable();
            $table->float('onGoingMonthlyFee')->nullable();
            $table->integer('businessMemberSignatureId')->unsigned()->nullable();
            $table->integer('topTenRepSignatureId')->unsigned()->nullable();
            $table->dateTime('lastUpdated')->nullable();
            $table->tinyInteger('isDeleted')->nullable();
            $table->tinyInteger('vip')->nullable();
            $table->tinyInteger('promo')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('businesscontracts');
    }
}
