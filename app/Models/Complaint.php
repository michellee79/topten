<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
	public $timestamps = false;

    public function businesses(){
    	return $this->belongsToMany('App\Model\Business', 'businesscomplaints', 'complaintsId', 'businessId');
    }

    public function user(){
    	return $this->belongsTo('App\Model\User', 'userId');
    }
}
