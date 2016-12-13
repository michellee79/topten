<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    public $timestamps = false;

    public function getSignedupUserCount(){
    	return $this->hasMany('App\Model\User', 'promoCode', 'code')->where('isDeleted', 0)->count();
    }

    public function getActivatedUserCount(){
    	return $this->hasMany('App\Model\User', 'promoCode', 'code')->where('isActivated', 1)->where('isDeleted', 0)->count();
    }
}
