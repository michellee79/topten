<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
	public $timestamps = false;
	protected $appends = ['ratedBy', 'date'];

    public function user(){
    	return $this->belongsTo('App\Model\User', 'userId');
    }

    public function businesses(){
    	return $this->belongTo('App\Model\Business', 'businessId');
    }

    public function getRatedByAttribute(){
    	return $this->user->firstName . ' ' . $this->user->lastName;
    }

    public function getDateAttribute(){
    	$date = \DateTime::createFromFormat('Y-m-d H:i:s', $this->submitted_on);
        return date_format($date, 'm-d-Y');
    }
}
