<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;
    
    public function users(){
    	return $this->belongsToMany('App\Model\User', 'usercoupons', 'couponId', 'userId');
    }

    public function businesses(){
    	return $this->belongsToMany('App\Model\Business', 'businesscoupons', 'couponId', 'businessId');
    }

    public function business(){
    	return $this->belongsTo('App\Model\Business', 'businessId');
    }

    public function couponViews(){
    	return $this->hasMany('App\Model\CouponView', 'couponId');
    }
}
