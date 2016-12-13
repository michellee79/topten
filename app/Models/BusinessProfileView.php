<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessProfileView extends Model
{
	public $timestamps = false;
	protected $table = 'businessprofileviews';
    public function business(){
    	return $this->belongsTo('App\Model\Business', 'businessId');
    }
}
