<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class CouponView extends Model
{
	protected $table = 'couponviews';
	public $timestamps = false;
	
    public function coupon(){
    	return $this->belongsTo('App\Model\Coupon', 'couponId');
    }
}
