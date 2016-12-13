<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessV extends Model
{
    protected $table = "vw_businesses";

    public function subCategory(){
        return $this->belongsTo('App\Model\BusinessSubCategory', 'businessSubCategoryId');
    }

    public function subCategory2(){
    	return $this->belongsTo('App\Model\BusinessSubCategory', 'businessSubCategoryId2');
    }

    public function profileViews(){
    	return $this->hasMany('App\Model\BusinessProfileView', 'businessId');
    }

    public function websiteViews(){
        return $this->hasMany('App\Model\BusinessWebsiteView', 'businessId');
    }

    public function ratings(){
        return $this->hasMany('App\Model\Rating', 'businessId')->where('isDeleted', 0)->where('isResolved', 1);
    }

    public function complaints(){
        return $this->hasMany('App\Model\Complaint', 'businessId')->where('isDeleted', 0);
//    	return $this->belongsToMany('App\Model\Complaint', 'businesscomplaints', 'businessId', 'complaintsId');
    }

    public function coupons(){
    	return $this->belongsToMany('App\Model\Coupon', 'businesscoupons', 'businessId', 'couponId');
    }

    public function images(){
    	return $this->belongsToMany('App\Model\GalleryImage', 'businessimages', 'businessId', 'imageId');
    }

    public function franchisees(){
    	return $this->belongsToMany('App\Model\Franchisee', 'businessfranchisees', 'businessId', 'franchiseeId');
    }

    public function logo(){
    	return $this->belongsTo('App\Model\LogoImage', 'logoId');
    }
}
