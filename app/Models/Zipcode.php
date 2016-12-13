<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Zipcode extends Model
{
    protected $table = 'zipcodes';
    public $timestamps = false;

    public function franchisees(){
    	return $this->belongsToMany('App\Model\Franchisee', 'franchiseezipcodes', 'zipcodeId', 'franchiseeId');
    }

}
