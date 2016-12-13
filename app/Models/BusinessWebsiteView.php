<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessWebsiteView extends Model
{
	public $timestamps = false;
	protected $table = 'businesswebsiteview';
    public function business(){
    	return $this->belongsTo('App\Model\Business', 'businessId');
    }
}
