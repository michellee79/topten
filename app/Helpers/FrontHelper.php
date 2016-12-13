<?php

namespace App\Helper;

use App\Model\USCity;
use App\Model\User;
use App\Model\Coupon;
use App\Model\Business;
use App\Model\Complaint;
use App\Model\Rating;
use App\Model\CouponView;
use App\Model\BusinessCategory;
use App\Model\BusinessSubCategory;
use App\Model\BusinessV;
use App\Model\NominatedBusiness;
use App\Model\Zipcode;
use App\Model\Promo;
use App\Model\BusinessProfileView;
use App\Model\Franchisee;
use App\Model\BusinessWebsiteView;

use App\MySession;

use Auth;

class FrontHelper{

	public static function getCoordinate($address){

		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=";
		$url = $url . urlencode($address);
   
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);

        curl_close($ch);

		return json_decode($output);
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

			$cp = $user->complaints()->where('isDeleted', 0)->where('businessId', $businessId)->first();
			if ($cp != NULL && $cp->isResolved == 0){ // did he complaint on this business before or is he come from business link for renew review?
				$cp->isResolved = 1;
				$cp->save();
			}

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

			$cp = $user->complaints()->where('isDeleted', 0)->where('businessId', $businessId)->first();
			if ($cp != NULL && $cp->isResolved == 0){
                return -2; // user already has submitted complaint
			} else{
				$cp = new Complaint;
				$cp->businessId = $businessId;
				$cp->userId = $userId;
				$cp->comment = $comment;
				$cp->rating = $rating;
				$cp->submitted_on = date("Y-m-d H:i:s");
				$cp->isResolved = 0;

				$cp->save();

				$frEmail = $business->franchisees[0]->contactEmail;
				$buEmail = $business->email;
				MailHelper::sendComplaintEmail($user, $business->name, $frEmail, $buEmail, $rating, $comment);
			}
		}

		return 1; // success

	}

	public static function viewBusiness($businessId, $userId, $ip){
		$business = Business::find($businessId);
		if ($business->profileViews()->where('userId', $userId)->first() == NULL){
			$pv = new BusinessProfileView;
			$pv->businessId = $businessId;
			$pv->ip = $ip;
			$pv->userId = $userId;
			$pv->viewedDate = date("Y-m-d H:i:s");
			$business->profileViews()->save($pv);
		}
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

	public static function viewWebsite($businessId, $userId, $ip){
		$business = Business::find($businessId);
		if ($business->websiteViews()->where('userId', $userId)->first() == NULL){
			$wv = new BusinessWebsiteView;
			$wv->businessId = $businessId;
			$wv->ip = $ip;
			$wv->userId = $userId;
			$wv->viewedDate = date("Y-m-d H:i:s");
			$business->websiteViews()->save($wv);
		}
	}

	public static function updateAccount($userId, $fname, $lname, $newZipcode){
		$user = User::find($userId);

		$zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
		if ($zipcode != NULL){
			$zipcode->totalActivatedUsers = $zipcode->totalActivatedUsers - 1;
			$zipcode->totalUsers = $zipcode->totalUsers - 1;
			$zipcode->save();
		}
		$user->firstName = $fname;
		$user->lastName = $lname;
		$user->zipcode = $newZipcode;
		$user->timestamps = false;
		$user->save();
		$zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
		if ($zipcode != NULL){
			$zipcode->totalActivatedUsers = $zipcode->totalActivatedUsers - 1;
			$zipcode->totalUsers = $zipcode->totalUsers - 1;
			$zipcode->save();
		}
	}

	public static function filterBusiness($group, $category, $subcat, $rad, $lat, $long){
		$groups = BusinessCategory::groupBy('ctGroup')->where('isDeleted', 0)->get();
		$cats = NULL;
		$subcats = NULL;
		$businesses = BusinessV::with('coupons')->where('isDeleted', 0)->where('isActive', 1);

		if ($rad != 'national'){
			$businesses = $businesses->whereRaw("CoordinateDistanceMiles(latitude, longitude, $lat, $long) <= $rad");
		}

		if ($group != ''){
			$cats = BusinessCategory::where('ctGroup', $group)->get();
			// $businesses = $businesses->where('ctGroup', $group);
			$businesses = $businesses->where(function($query) use ($group){
				$query->where('ctGroup', $group);
				$query->orWhere('ctGroup2', $group);
			});
			if ($category != ''){
				// $businesses = $businesses->where('parentCategoryId', $category);
				$businesses = $businesses->where(function($query) use ($category){
					$query->where('parentCategoryId', $category);
					$query->orWhere('parentCategoryId2', $category);
				});
				$subcats = BusinessSubCategory::where('parentCategoryId', $category)->get();
				if ($subcat != '') {
					// $businesses = $businesses->where('businessSubCategoryId', $subcat);
					$businesses = $businesses->where(function($query) use ($subcat){
						$query->where('businessSubCategoryId', $subcat);
						$query->orWhere('businessSubCategoryId2', $subcat);
					});
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
            if ($c != NULL){
                $bi->coupon = $c->title;
                $bi->couponId = $c->id;
            }
            $bi->address = $b->address;
            $bi->city = $b->city;
            $bi->state = $b->state;
            $bi->zipcode = $b->zipcode;
            $bi->avgRating = $b->averageRating;
            $bi->summary = $b->summary;

            $bi->logo = $b->logo->url;

            $bis[] = $bi;
        }

        $tgroups = [];
		foreach ($groups as $g){
			$tgroups[] = $g->ctGroup;
		}

		$tcats = [];
		if ($cats != null){
			foreach ($cats as $c) {
				$tcats[] = array(
					'id' => $c->id,
					'value' => $c->category
					);
			}
		}

		$tsubcats = [];
		if ($subcats != null){
			foreach ($subcats as $s) {
				$tsubcats[] = array(
					'id' => $s->id,
					'value' => $s->subCategory
					);
			}
		}

		$result = array(
			'groups' => $groups,
			'categories' => $cats,
			'subcats' => $subcats,
			'businesses' => $businesses,
			'json' => $bis,
			'tgroups' => $tgroups,
			'tcats' => $tcats,
			'tsubcats' => $tsubcats
			);
 
		return $result;
	}

	public static function findBusiness($name, $rad, $lat, $lng){
		// $businesses = BusinessV::where('name', 'like', $name . '%')->where('isDeleted', 0)->where('isActive', 1);
		$name = str_replace("'", "", $name);
		$businesses = BusinessV::whereRaw("replace(name, '\'', '') like '%{$name}%'")->where('isDeleted', 0)->where('isActive', 1);

		if ($rad != 'national'){
			$businesses = $businesses->whereRaw("CoordinateDistanceMiles(latitude, longitude, $lat, $lng) <= $rad");
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
            if ($c != NULL){
                $bi->coupon = $c->title;
                $bi->couponId = $c->id;
            }
            $bi->address = $b->address;
            $bi->city = $b->city;
            $bi->state = $b->state;
            $bi->zipcode = $b->zipcode;
            $bi->avgRating = $b->averageRating;
            $bi->summary = $b->summary;
            $bi->logo = $b->logo->url;
            $bis[] = $bi;
        }
		$result = array(
			'businesses' => $businesses,
			'json' => $bis,
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
		$nb->isApproved = 0;
		$nb->isDeleted = 0;
		if ($zipcode != ''){
			$nb->franchiseId = FrontHelper::getFranchiseIdOfUser($zipcode);
		}
		$franchisee = Franchisee::find($nb->franchiseId);
		if ($franchisee == NULL){
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
			$nb->franchiseId = $franchisee->id;
		}
		$nb->save();
		
		// $param = 'lp_Username=' . $franchisee->lmUser . '&lp_Password=' . $franchisee->lmPassword . '&lp_CompanyID=' . $franchisee->lmGroup . 
		// 		'&First_Name=' . $fname . '&Last_Name=' . $lname . '&Business_Name=' . $name . '&Business_City=' . $city . '&Business_State=' . $state .
		// 		'&Business_Phone=' . $phone . '&Email=' . $email . '&Reason=' . $feel;

		$url = "http://app.crmtool.net/lp_NewLead.asp";

		if ($franchisee->lmGroup != NULL && $franchisee->lmGroup != ''){

			$params = "lp_Username={$franchisee->lmUser}&lp_Password={$franchisee->lmPassword}&lp_CompanyID={$franchisee->lmGroup}&First_Name={$fname}&Last_Name={$lname}&Business_Name={$name}&Business_City={$city}&Business_State={$state}&Business_Phone={$phone}&Email={$email}&Reason={$feel}";
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => "http://app.crmtool.net/lp_NewLead.asp",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $params,
			  CURLOPT_HTTPHEADER => array(
			    "cache-control: no-cache",
			    "content-type: application/x-www-form-urlencoded",
			  ),
			));

			$response = curl_exec($curl);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			MailHelper::sendNominationEmail($nb);
			return $params . $response;
			
		}

		
		// http://app.crmtool.net/lp_NewLead.asp?lp_Username=ttpknoble101&lp_Password=newuser&lp_CompanyID=22936&First_Name='value'&Last_Name='value'&Business_Name='value'&Business_City='value'&Business_State='value'&Business_Phone='value'&Email='value'&Reason='value'
		// $ch = curl_init('http://app.crmtool.net/lp_NewLead.asp');
		//curl_setopt($ch, CURLOPT_URL, '');
		// curl_setopt($ch, CURLOPT_VERBOSE, 1);
		// curl_setopt ($ch, CURLOPT_POST, 11);
		// curl_setopt ($ch, CURLOPT_POSTFIELDS, $param);
		// curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
		// curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
		// curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
		// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		// $response = curl_exec($ch);

		// $url = 'http://app.crmtool.net/lp_NewLead.asp?' . $param;
		//$response = file_get_contents($url);


		MailHelper::sendNominationEmail($nb);

		return 'no crm info';
	}

	public static function getFranchiseIdOfUser($zipcode){
		$z = Zipcode::where('zipcode', $zipcode)->first();
		if ($z == NULL)
			return 0;
		$franchisee = $z->franchisees()->first();
		if ($franchisee == NULL)
			return 0;
		return $franchisee->id;
	}

	public static function createUser($promo, $firstName, $lastName, $zipcode, $email, $pwd, $active, $sendEmail=true){
		// $o = User::where('email', $email)->orWhere('loginName', $email)->where('isDeleted', 0)->count();
		$o = User::where(function($query) use ($email){
			$query->where('email', $email)->orWhere('loginName', $email);
		})->where('isDeleted', 0)->count();
		if ($o > 0)
			return -1; // email is already used.

		$user = new User;

		$p = Promo::where('code', $promo)->where('isDeleted', 0)->first();
		// $active = false;

		if ($promo !== NULL){ // using promocode?
			if ($p == NULL)
				return 0; // no such promocode
			$user->promoCode = $promo;
			$user->promoId = $p->id;
			$p->totalSignedUp = $p->totalSignedUp + 1;
			$active = $p->requireActivation == 1 ? 0 : 1;
			$p->save();
		}

		$user->firstName = $firstName;
		$user->lastName = $lastName;
		$user->zipcode = $zipcode;
		$user->email = $email;
		$user->loginName = $email;
		$salt = date('Y-m-dH:i:s');
		$user->passwordSalt = base64_encode($salt);
		$utf16Password = mb_convert_encoding($pwd, 'UTF-16LE', 'UTF-8');
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

		if ($sendEmail){
            if ($active){

                try {
                    MailHelper::sendWelcomeEmail($user);
                } catch(Exception $ex) {}

                $zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
                if ($zipcode != NULL){
                    $zipcode->totalActivatedUsers = $zipcode->totalActivatedUsers + 1;
                    $zipcode->totalUsers = $zipcode->totalUsers + 1;
                    $zipcode->save();
                }
                return 2;
            } else {

                try{
                    MailHelper::sendActivationEmail($user);
                } catch(Exception $ex) {}

                $zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
                if ($zipcode != NULL){
                    $zipcode->totalUsers = $zipcode->totalUsers + 1;
                    $zipcode->save();
                }
                return 1;
            }
		}
		return 1;
	}

	public static function activateUser($uid){
		$user = User::find($uid);
		if ($user == NULL) {
			return false;
		}
		$user->isActivated = true;
		$user->timestamps = false;
		$user->save();
		$p = Promo::where('code', $user->promoCode)->where('isDeleted', 0)->first();
		$p->totalActivated = $p->totalActivated + 1;
		$p->save();
		$zipcode = Zipcode::where('zipcode', $user->zipcode)->first();
		if ($zipcode != NULL){
			$zipcode->totalActivatedUsers = $zipcode->totalActivatedUsers + 1;
			$zipcode->save();
		}
		MailHelper::sendWelcomeEmail($user);
		return true;
	}

    public static function resetUserPassword($email, $question, $answer){
    	$user = User::where('email', 'like', $email)->where('isDeleted', 0)->first();
    	if ($user == NULL){
    		return false;
    	}

    	// if ($user->question == $question && strtolower($user->answer) == strtolower($answer)){
    	if (strtolower($user->answer) == strtolower($answer)){
    		$salt = date('Y-m-dH:i:s');
			$user->passwordSalt = base64_encode($salt);
			$utf16Password = mb_convert_encoding('topten', 'UTF-16LE', 'UTF-8');
			$user->password = base64_encode(sha1($salt . $utf16Password, true));
			$user->timestamps = false;
			$user->save();
			MailHelper::sendNewPasswordEmail($user, 'topten');
			return true;
    	}
    	return false;
    }

    public static function confirmComplaint($uid, $cid){
    	$user = User::find($uid);
    	$complaint = $user->complaints()->where('isDeleted', 0)->where('id', $cid)->first();
    	$result = array();
    	if ($complaint != NULL){
    		if ($complaint->isResolved){
    			$result['success'] = 'false';
    			$result['message'] = "Consumers are given seven days to respond to the email that was sent.
    			 This time has expired and no further action can be processed.
    			 Thank you.";
    		} else{
                $complaint->isResolved = 1;
                $complaint->isPublished = 1;
                $complaint->save();

                $business = Business::find($complaint->businessId);

                $rt = new Rating;
                $rt->comment = $complaint->comment;
                $rt->businessId = $complaint->businessId;
                $rt->rating = $complaint->rating;
                $rt->submitted_on = $complaint->submitted_on;
                $displayedRating = $business->ratings()->where('isDeleted', '=', 0)
                                                    ->where('isDisplayed', '=', 1)
                                                    ->first();
                if ($displayedRating == NULL){
                    $rt->isDisplayed = 1;
                } else{
                    $rt->isDisplayed = 0;
                }

                $rt->isResolved = 1;
                $rt->userId = $uid;

                $rt->save();
                $franchisee = $business->franchisees[0];

                MailHelper::sendNewReviewEmail($user, $business, $franchisee->contactEmail);

                $result['success'] = 'true';
                $result['message'] = 'Review has been published.';
//	    		}
    		}
    	} else {
    		$result['success'] = 'false';
    		$result['message'] = "We're not able to find your complaint.";
    	}
    	return $result;
    }


	public static function currentCoupon($coupons){
        foreach ($coupons as $coupon) {
            if ($coupon->isActive && !$coupon->isDeleted)
                return $coupon;
        }
        return NULL;
    }

}

?>