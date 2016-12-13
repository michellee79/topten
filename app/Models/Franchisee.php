<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\User;
class Franchisee extends Model
{
	public $timestamps = false;
    public function businesses(){
    	return $this->belongsToMany('App\Model\Business', 'businessfranchisees', 'franchiseeId', 'businessId');
    }

    public function businessVs(){
        return $this->belongsToMany('App\Model\BusinessV', 'businessfranchisees', 'franchiseeId', 'businessId');
    }

    public function zipcodes(){
    	return $this->belongsToMany('App\Model\Zipcode', 'franchiseezipcodes', 'franchiseeId', 'zipcodeId');
    }

    public function users(){
    	return $this->hasMany('App\Model\User', 'franchiseId');
    }

    public function businessSelections(){
        return $this->hasMany('App\Model\BusinessSelection', 'franchiseId');
    }

    public function localConsumers() {
        $zipcode_arr = [];
        foreach($this->zipcodes as $zipcode) {
            $zipcode_arr[] = $zipcode->zipcode;
        }

        return User::whereIn('zipcode', $zipcode_arr);
    }
}
