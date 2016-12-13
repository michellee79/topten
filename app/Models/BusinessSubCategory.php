<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessSubCategory extends Model
{
    protected $table = "businesssubcategories";
    public $timestamps = false;

    public function businesses(){
    	return $this->hasMany('App\Model\Business', 'subCatId');
    }
}
