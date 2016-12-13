<?php

namespace App;

use App\Helper\FrontHelper;

class MySession{
	public static function setZipcode($zipcode){
		session(['zipcode' => $zipcode]);
		if ($zipcode == NULL)
			return false;
		$r = FrontHelper::getCoordinate($zipcode);
		if ($r->status == 'OK'){
			session(['latitude' => $r->results[0]->geometry->location->lat]);
			session(['longitude'=> $r->results[0]->geometry->location->lng]);
			return true;
		}
		return false;
	}

	public static function getZipcode(){
		return session('zipcode');
	}

	public static function getLatitude(){
		return session('latitude');
	}

	public static function getLongitude(){
		return session('longitude');
	}

	public static function setRegisterPromoStep($step){
		session(['register_promo_step' => $step]);
	}

	public static function getRegisterPromoStep(){
		return session('register_promo_step');
	}

	public static function setRegisterNominationStep($step){
		session(['register_nomination_step' => $step]);
	}

	public static function getRegisterNominationStep(){
		return session('register_nomination_step');
	}

	public static  function get($key, $default=NULL){
		$val = session($key);
		if ($val == NULL)
			return $default;
		return $val;
	}

	public static function set($key, $value){
		session([$key => $value]);
	}

}

?>