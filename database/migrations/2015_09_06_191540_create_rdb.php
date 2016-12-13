<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRdb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('businesses', function($table){
            $table->foreign('subCatId')->references('id')->on('businesssubcategories');
        });
        Schema::table('complaints', function($table){
            $table->foreign('userId')->references('id')->on('users');
        });
        Schema::table('ratings', function($table){
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('businessId')->references('id')->on('businesses');
        });
        Schema::table('businessprofileviews', function($table){
            $table->foreign('businessId')->references('id')->on('businesses');
        });
        Schema::table('usercoupons', function($table){
            $table->foreign('userId')->references('id')->on('users');
            $table->foreign('couponId')->references('id')->on('coupons');
        });
        Schema::table('businesscoupons', function($table){
            $table->foreign('couponId')->references('id')->on('coupons');
            $table->foreign('businessId')->references('id')->on('businesses');
        });
        Schema::table('couponviews', function($table){
            $table->foreign('couponId')->references('id')->on('coupons');
        });
        Schema::table('businessimages', function($table){
            $table->foreign('businessId')->references('id')->on('businesses');
            $table->foreign('imageId')->references('id')->on('galleryimages');
        });
        Schema::table('businessfranchisees', function($table){
            $table->foreign('businessId')->references('id')->on('businesses');
            $table->foreign('franchiseeId')->references('id')->on('franchisees');
        });
        Schema::table('franchiseezipcodes', function($table){
            $table->foreign('franchiseeId')->references('id')->on('franchisees');
            $table->foreign('zipcodeId')->references('id')->on('zipcodes');
        });
        Schema::table('businesscontracts', function($table){
            $table->foreign('businessMemberSignatureId')->references('id')->on('signatureimages');
            $table->foreign('topTenRepSignatureId')->references('id')->on('signatureimages');
        });
        Schema::table('users', function($table){
            $table->foreign('promoId')->references('id')->on('promos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('businesses', function($table){
            $table->dropForeign('businesses_subcatid_foreign');
        });
        Schema::table('complaints', function($table){
            $table->dropForeign('complaints_userid_foreign');
        });
        Schema::table('ratings', function($table){
            $table->dropForeign('ratings_userid_foreign');
            $table->dropForeign('ratings_businessid_foreign');
        });
        Schema::table('businessprofileviews', function($table){
            $table->dropForeign('businessprofileviews_businessid_foreign');
        });
        Schema::table('usercoupons', function($table){
            $table->dropForeign('usercoupons_userid_foreign');
            $table->dropForeign('usercoupons_couponid_foreign');
        });
        Schema::table('businesscoupons', function($table){
            $table->dropForeign('businesscoupons_couponid_foreign');
            $table->dropForeign('businesscoupons_businessid_foreign');
        });
        Schema::table('couponviews', function($table){
            $table->dropForeign('couponviews_couponid_foreign');
        });
        Schema::table('businessimages', function($table){
            $table->dropForeign('businessimages_businessid_foreign'); 
            $table->dropForeign('businessimages_imageid_foreign');
        });
        Schema::table('businessfranchisees', function($table){
            $table->dropForeign('businessfranchisees_businessid_foreign'); 
            $table->dropForeign('businessfranchisees_franchiseeid_foreign');
        });
        Schema::table('franchiseezipcodes', function($table){
            $table->dropForeign('franchiseezipcodes_franchiseeid_foreign');
            $table->dropForeign('franchiseezipcodes_zipcodeid_foreign'); 
        });
        Schema::table('businesscontracts', function($table){
            $table->dropForeign('businesscontracts_businessmembersignatureid_foreign');
            $table->dropForeign('businesscontracts_toptenrepsignatureid_foreign'); 
        });
        Schema::table('users', function($table){
            $table->dropForeign('users_promoid_foreign');
        });
    }
}
