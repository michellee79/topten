<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
	protected $table = 'galleryimages';
	public $timestamps = false;
	
    public function businesses(){
    	return $this->belongsToMany('App\Model\Businesses', 'businessImages', 'imageId', 'businessId');
    }
}
