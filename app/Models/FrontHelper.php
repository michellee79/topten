<?php

namespace App\Model;

use App\Model\USCity;
use App\Model\User;
use App\Model\Coupon;
use App\Model\Business;
use App\Model\Complaint;
use App\Model\Rating;
use App\Model\MailHelper;
use App\Model\CouponView;
use App\Model\BusinessCategory;
use App\Model\BusinessSubCategory;
use App\Model\BusinessV;
use App\Model\NominatedBusiness;
use App\Model\Zipcode;
use App\Model\Promo;
use App\Model\Franchisee;

use App\Model\MySession;

use Auth;

class FrontHelper{

	public static function getCoordinate($address){
		$ch = curl_init();

		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=";
		$url = $url . urlencode($address);

		$geoloc = file_get_contents($url);

		return json_decode($geoloc);
	}

	public static function getlocations($search){
		$intval = intval($search);
		$result = array();
		if ($intval > 0){ // Search by zipcode
			$zipcodes = USCity::where('Zipcode', 'like', $search . '%')->get();

			foreach ($zipcodes as $usCity){
				$result[] = $usCity->zipCode . ' - ' . $usCity->city . ', ' . $usCity->state;
			}
		} else{
			$cities = USCity::where('City', 'like', $search . '%')->get();

			foreach ($cities as $city) {
				$val = $city->city . ', ' . $city->state;
				if (!in_array($val, $result)){
					$result[] = $val;
				}
			}
		}
		return $result;
	}

	public static function addToMyCoupon($userId, $couponId){
		$user = User::find($userId);
		if ($user->coupons()->find($couponId) == NULL){
			$user->coupons()->attach($couponId);
			return 1;
		}
		return 0;
	}

	public static function removeFromMyCoupon($userId, $couponId){
		$user = User::find($userId);
		$user->coupons()->detach($couponId);
	}

	public static function addReview($businessId, $userId, $rating, $comment){
		$business = Business::find($businessId);
		$coupon = $business->coupons()->where('isActive', '=', 1)
									->where('isDeleted', '=', 0)
									->first();
		$user = User::find($userId);
		$inUserRatings = $business->ratings()->where('userId', '=', $userId)
											->where('isDeleted', '=', 0)
											->first(); // did user rate this business?
		if ($inUserRatings != NULL){
			return 0; // user already rated
		}

		$inUserCoupons = NULL;
		$inUserViews = NULL;
		if ($coupon != NULL){
			$inUserCoupons = $user->coupons()->where('coupons.id', '=', $coupon->id)->first(); // does this user have this coupon?
			$inUserViews = $coupon->couponViews()->where('userId', '=', $userId)->first(); // does this user see this coupon?
		}

		if ($inUserViews == NULL && $inUserViews == NULL){
			return -1; // user hasn't seen or downloaded coupon
		}

		if ($rating > 2){
			$rt = new Rating;
			$rt->comment = $comment;
			$rt->businessId = $businessId;
			$rt->rating = $rating;
			$rt->submitted_on = date('Y-m-d H:i:s');
			$displayedRating = $business->ratings()->where('isDeleted', '=', 0)
												->where('isDisplayed', '=', 1)
												->first();
			if ($displayedRating == NULL){
				$rt->isDisplayed = 1;
			} else{
				$rt->isDisplayed = 0;
			}

			$rt->isResolved = 1;
			$rt->isDeleted = 0;
			$rt->userId = $userId;

			$business->ratings()->save($rt);
		} else{
			$cp = new Complaint;
			$cp->businessId = $businessId;
			$cp->userId = $userId;
			$cp->comment = $comment;
			$cp->rating = $rating;
			$cp->submitted_on = date("Y-m-d H:i:s");
			$cp->isResolved = 1;
			$cp->isDeleted = 0;

			$cp->save();

			$frEmail = $business->franchisees[0]->contactEmail;
			$buEmail = $business->email;
			MailHelper::sendComplaintEmail($user, $business->name, $frEmail, $buEmail, $rating, $comment);
		}

		return 1; // success

	}

	public static function viewCoupon($couponId, $userId, $ip){
		$coupon = Coupon::find($couponId);
		if ($coupon->couponViews()->where('userId', '=', $userId)->first() == NULL){
			$cv = new CouponView;
			$cv->userId = $userId;
			$cv->ip = $ip;
			$cv->viewedDate = date("Y-m-d H:i:s");
			$coupon->couponViews()->save($cv);
		}
	}

	public static function updateAccount($userId, $fname, $lname, $zipcode){
		$user = User::find($userId);
		$user->firstName = $fname;
		$user->lastName = $lname;
		$user->zipcode = $zipcode;
		$user->timestamps = false;
		$user->save();
	}

	public static function filterBusiness($group, $category, $subcat, $rad, $lati, $long){
		$groups = BusinessCategory::groupBy('ctGroup')->get();
		$cats = NULL;
		$subcats = NULL;
		$businesses = BusinessV::where('isDeleted', 0)->where('isActive', 1);

		if ($rad != 'national'){
			$businesses = $businesses->whereRaw("CoordinateDistanceMiles(latitude, longitude, $lati, $long) <= $rad");
		}

		if ($group != ''){
			$cats = BusinessCategory::where('ctGroup', $group)->get();
			$businesses = $businesses->where('ctGroup', $group);
			if ($category != ''){
				$businesses = $businesses->where('parentCategoryId', $category);
				$subcats = BusinessSubCategory::where('parentCategoryId', $category)->get();
				if ($subcat != '') {
					$businesses = $businesses->where('businessSubCategoryId', $subcat);
					$subcats = BusinessSubCategory::where('parentCategoryId', $category)->get();
				}
			}
		}

		$businesses = $businesses->orderBy('averageValue', 'desc')->get();

		$bis = array();
        foreach ($businesses as $b) {
            $bi = new \stdClass;
            $bi->id = $b->id;
            $bi->lat = $b->latitude;
            $bi->lng = $b->longitude;
            $bi->name = $b->name;
            $bi->phone = $b->phone;
            $c = FrontHelper::currentCoupon($b->coupons);
            if ($c != NULL)
                $bi->coupon = $c->title;
            $bi->address = $b->address;
            $bi->city = $b->city;
            $bi->state = $b->state;
            $bi->zipcode = $b->zipcode;
            $bis[] = $bi;
        }

		$result = array(
			'groups' => $groups,
			'categories' => $cats,
			'subcats' => $subcats,
			'businesses' => $businesses,
			'json' => json_encode($bis, JSON_HEX_APOS),
			);
 
		return $result;
	}

	public static function changePassword($user, $oldPass, $newPass){
		if (Auth::attempt(array('email' => $user->email, 'password' => $oldPass))) {
			$salt = base64_decode($user->passwordSalt);
			$utf16Password = mb_convert_encoding($newPass, 'UTF-16LE', 'UTF-8');
			$calculatedPassword = base64_encode(sha1($salt . $utf16Password, true));
			$user->password = $calculatedPassword;
			$user->timestamps = false;
			$user->save();
			return true;
		}
		return false;
	}

	public static function nominateBusiness($zipcode, $name, $city, $state, $phone, $fname, $lname, $email, $feel){
		$nb = new NominatedBusiness;
		$nb->businessName = $name;
		$nb->businessCity = $city;
		$nb->businessState = $state;
		$nb->businessPhone = $phone;
		$nb->firstName = $fname;
		$nb->lastName = $lname;
		$nb->email = $email;
		$nb->nominationReason = $feel;
		$nb->dateSubmitted = date('Y-m-d H:i:s');
		$nb->franchiseId = FrontHelper::getFranchiseIdOfUser($zipcode);
		$nb->save();

        $franchiseId = $nb->franchiseId;
		return Franchisee::find($franchiseId);
	}

	public static function getFranchiseIdOfUser($zipcode){
		$z = Zipcode::where('zipcode', $zipcode)->first();
		$franchisee = $z->franchisees()->first();
		if ($franchisee == NULL)
			return 0;
		return $franchisee->id;
	}

	public static function createUser($promo, $firstName, $lastName, $zipcode, $email, $pswd, $active){
		$o = User::where('email', $email)->orWhere('loginName', $email)->count();
		if ($o > 0)
			return -1; // email is already used.

		$user = new User;

		if ($active == false){ // using promocode?
			$p = Promo::where('code', $promo)->count();
			if ($p == 0)
				return 0; // no such promocode
			$user->promoCode = $promo;
		}

		$user->firstName = $firstName;
		$user->lastName = $lastName;
		$user->zipcode = $zipcode;
		$user->email = $email;
		$user->loginName = $email;
		$salt = date('Y-m-dH:i:s');
		$user->passwordSalt = base64_encode($salt);
		$utf16Password = mb_convert_encoding($pswd, 'UTF-16LE', 'UTF-8');
		$user->password = base64_encode(sha1($salt . $utf16Password, true));
		$user->timestamps = false;
		$user->isActivated = $active;
		$user->question = 'What is the name of this site?';
		$user->answer = 'Top Ten Percent';
		$user->createdDate = date('Y-m-d H:i:s');
		$user->isDeleted = false;
		if ($active){
			$user->activationDate = date('Y-m-d H:i:s');
		}
		$user->firstTimeLogin = true;
		$user->mobilePhone = '';
		$user->role = 0;
		$user->save();
		return true;
	}

	static function currentCoupon($coupons){
        foreach ($coupons as $coupon) {
            if ($coupon->isActive && !$coupon->isDeleted)
                return $coupon;
        }
        return NULL;
    }
}

?>