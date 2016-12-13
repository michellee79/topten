<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BusinessContract extends Model
{
	public $timestamps = false;
	protected $table = 'businesscontracts';

    public function businessMemberSignature(){
    	return $this->belongsTo('App\Model\SignatureImage', 'businessMemberSignatureId');
    }

    public function topTenRepSignature(){
    	return $this->belongsTo('App\Model\SignatureImage', 'topTenRepSignatureId');
    }

    public function business(){
    	return $this->belongsTo('App\Model\Business', 'businessId');
    }
}
