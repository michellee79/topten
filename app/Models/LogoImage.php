<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LogoImage extends Model
{
	protected $table = 'logoimages';
	public $timestamps = false;
	
    public function business(){
    	return $this->hasOne('App\Model\Business', 'logoId');
    }
}
