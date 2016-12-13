<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\User;
use App\Model\TotalSaving;
use App\Model\LoginToken;
use App\Model\BusinessV;
use App\Model\Coupon;
use App\Model\Zipcode;

use Auth;

use App\MySession;
use App\Helper\FrontHelper;
use App\Helper\MailHelper;
use App\Helper\CronHelper;

use Illuminate\Http\Request;

class APIController extends Controller{

	public function getCounters(){
		$totalSavings = TotalSaving::find(1)->totalsavings;
		$totalUsers = User::where('isDeleted', 0)->count();
		$data = array(
			'savings' => intval($totalSavings),
			'accounts' => $totalUsers,
			);
		return json_encode(array(
			'success' => true,
			'message' => 'Successfully counted.',
			'value' => $data,
			));
	}

	public function getLocation(Request $request){
		$str = $request->input('search');
		$locations = FrontHelper::getlocations($str);
		return json_encode(array(
			'success' => true,
			'message' => 'Successfully fetched locations.',
			'result' => $locations,
			));
	}

	public function loginWithMember(Request $request){
		$userName = $request->input('userName');
		$userPass = $request->input('userPass');
		$deviceType = $request->input('deviceType');
		$deviceToken = $request->input('deviceToken');

		$result = array();

		if (User::where('loginName', 'like', $userName)->orWhere('email', 'like', $userName)->count() > 0){
			if (Auth::attempt(array('email' => $userName, 'password' => $userPass))){
				$user = Auth::user();

				if ($user->isDeleted){
					$result['success'] = false;
					$result['message'] = 'This user no longer exists.';
				} else if (!$user->isActivated){
					$result['success'] = false;
					$result['message'] = 'This user is not activated';
				} else{
					LoginToken::where('userId', $user->id)->delete();

					$logintoken = new LoginToken;
					$logintoken->userId = $user->id;
					$logintoken->token = md5($user->email . date('Y-m-d H:m:s'));
					if ($user->zipcode != NULL && $user->zipcode != ''){
						$r = FrontHelper::getCoordinate($user->zipcode);
						$logintoken->latitude = $r->results[0]->geometry->location->lat;
						$logintoken->longitude = $r->results[0]->geometry->location->lng;
					}
					$logintoken->lastSeen = date('Y-m-d H:m:s');
					$logintoken->devType = $deviceType;
					$logintoken->devToken = $deviceToken;

					$logintoken->save();

					$result['success'] = true;
					$result['message'] = 'Successfully logged in.';
                    $result['token'] = $logintoken->token;
					$result['value'] = array(
						'ID'        => $user->id,
						'FirstName' => $user->firstName,
						'LastName'  => $user->lastName,
						'Email'     => $user->email,
						'Zipcode'   => $user->zipcode
                    );
				}
			} else{
				$result['success'] = false;
				$result['message'] = 'Wrong password';
			}
		} else{
			$result['success'] = false;
			$result['message'] = 'No such user';
		}
		return json_encode($result);
	}

	public function loginWithNonMember(Request $request)
    {
        try {
            $address = $request->input('address');
            $deviceType = $request->input('deviceType');
            $deviceToken = $request->input('deviceToken');

            LoginToken::where('userId', 0)->where('devType', $deviceType)->where('devToken', $deviceToken)->delete();

            $logintoken = new LoginToken;
            $logintoken->userId = 0;
            $logintoken->token = md5('non-member' . date('Y-m-d H:m:s'));
            $logintoken->zipcode = $address;
            if (!empty($address)) {
                $r = FrontHelper::getCoordinate($address);
                if ($r->status == "OK") {
                    $logintoken->latitude = $r->results[0]->geometry->location->lat;
                    $logintoken->longitude = $r->results[0]->geometry->location->lng;
                }
            }
            $logintoken->lastSeen = date('Y-m-d H:m:s');
            $logintoken->devType = $deviceType;
            $logintoken->devToken = $deviceToken;

            $logintoken->save();
            $result = array(
                'success' => true,
                'message' => 'Successfully logged in as a guest',
                'token' => $logintoken->token
            );
            return json_encode($result);
        } catch (\Exception $ex) {
            return var_dump($ex);
        }
    }

	public function logout(Request $request){
		$token = $request->input('userToken');

		LoginToken::where('token', $token)->delete();

		$result = array(
			'success' => true,
			'message' => 'Successfully logged out.'
			);

		return json_encode($result);
	}

	public function checkAccountExist(Request $request){
		$name = $request->input('name');
        $query = User::where('email', 'like', $name)->orWhere('loginName', 'like', $name);
		$cnt = $query->count();
        $user = $query->first();
		$result = array();
		if ($cnt > 0){
			$result['success'] = true;
			$result['message'] = 'Valid User';
			$result['question'] = $user->question;
		} else{
			$result['success'] = false;
			$result['message'] = "The username $name was not found. Please check your value and reenter your username";
		}
		return json_encode($result);
	}

	public function registerByNomination(Request $request){
		$result = array();

		$fname = $request->input('firstName');
		$lname = $request->input('lastName');
		$zipcode = $request->input('zipCode');
		$email = $request->input('email');
		$pswd = $request->input('password');

		$name1 = $request->input('businessName1');
		$city1 = $request->input('businessCity1');
		$state1 = $request->input('businessState1');
		$phone1 = $request->input('businessPhone1');
		$reason1 = $request->input('reason1');

		$name2 = $request->input('businessName2');
		$city2 = $request->input('businessCity2');
		$state2 = $request->input('businessState2');
		$phone2 = $request->input('businessPhone2');
		$reason2 = $request->input('reason2');

		if ($fname == '' || $lname == '' || $zipcode == '' || $email == '' || $name1 == '' || $name2 == '' || $city1 == '' || $city2 == '' || $state1 == '' || $state2 == '' || $reason1 == '' || $reason2 == ''){
			$result['success'] = false;
			$result['message'] = 'Please complete all information.';
		} else{
			$cnt = $user = User::where('email', 'like', $email)->orWhere('loginName', 'like', $email)->count();
			if ($cnt > 0){
				$result['success'] = false;
				$result['message'] = 'This email has already been used.';
			} else{
				FrontHelper::nominateBusiness($zipcode, $name1, $city1, $state1, $phone1, $fname, $lname, $email, $reason1);
				FrontHelper::nominateBusiness($zipcode, $name2, $city2, $state2, $phone2, $fname, $lname, $email, $reason2);

				FrontHelper::createUser(NULL, $fname, $lname, $zipcode, $email, $pswd, true);
				$result['success'] = true;
				$result['message'] = "Successfully registered by Nominating Business.";
			}
		}
		return json_encode($result);
	}

	public function registerByPromocode(Request $request){
		$result = array();
		$promo = $request->input('promoCode');
		$fname = $request->input('firstName');
		$lname = $request->input('lastName');
		$zipcode = $request->input('zipCode');
		$email = $request->input('email');
		$pswd = $request->input('password');
		if ($promo == '' || $fname == '' || $lname == '' || $zipcode == '' || $email == '' || $email == ''){
			$result['success'] = false;
			$result['message'] = 'Please complete all information.';
		} else{
			$r = FrontHelper::createUser($promo, $fname, $lname, $zipcode, $email, $pswd, true);
			if ($r == 1 || $r == 2) {
				$result['success'] = true;
				$result['message'] = 'Successfully registered.';
			} else if ($r == -1){
				$result['success'] = false;
				$result['message'] = 'This email is already used.';
			} else{
				$result['success'] = false;
				$result['message'] = 'No such Promocode.';
			}
		}
		return json_encode($result);
	}

	public function forgotPassword(Request $request){
		$email = $request->input('name');
		$answer = $request->input('answer');
		$question = $request->input('question');
		$result = array();
		$r = FrontHelper::resetUserPassword($email, $question, $answer);
		if ($r == false){
			$result['success'] = false;
			$result['message'] = 'No such user';
		} else{
			$result['success'] = true;
			$result['message'] = 'Password has been reset. Your new password has been sent to you by email.';
		}
		return json_encode($result);
	}

	public function updateProfile(Request $request){
		$fname = $request->input('firstName');
		$lname = $request->input('lastName');
		$zipcode = $request->input('zipCode');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = "No such user";
		} else{
			FrontHelper::updateAccount($ltoken->userId, $fname, $lname, $zipcode);
			$result['success'] = true;
			$result['message'] = 'Your profile has been updated successfully.';
		}

		return json_encode($result);
	}

	public function getMyProfile(Request $request){
		$token = $request->input('token');

		$ltoken = $this->getLoginToken($token);
		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Please log in.';
		} else{
			$user = User::find($ltoken->userId);
            $result['success'] = true;
            if($user) {
                $result['value'] = array(
                    'Email'     => $user->email,
                    'FirstName' => $user->firstName,
                    'LastName'  => $user->lastName,
                    'Zipcode'   => $user->zipcode
                );
            }
            else {
                $result['value'] = [];
            }
		}
		return json_encode($result);
	}




	public function nominateBusiness(Request $request){
		$name = $request->input('businessName');
		$city = $request->input('businessCity');
		$state = $request->input('businessState');
		$phone = $request->input('businessPhone');

		$fname = $request->input('firstName');
		$lname = $request->input('lastName');
		$email = $request->input('email');
		$feel = $request->input('reason');

		$token = $request->input('token');

		$result = array();

		if ($name == '' || $fname == '' || $lname == '' || $email == '' || $feel == ''){
			$result['success'] = false;
			$result['message'] = 'Please complete all information.';
		} else{
			$ltoken = $this->getLoginToken($token);

			if ($ltoken == NULL){
				$result['success'] = false;
				$result['message'] = 'Please log in.';
			} else{
				$user = User::find($ltoken->userId);
				if ($user != NULL){
					FrontHelper::nominateBusiness($user->zipcode, $name, $city, $state, $phone, $fname, $lname, $email, $feel);
					$result['success'] = true;
					$result['message'] = 'Successfully nominated';
				} else{
					FrontHelper::nominateBusiness('', $name, $city, $state, $phone, $fname, $lname, $email, $feel);
					$result['success'] = true;
					$result['message'] = 'Successfully nominated';
				}
			}
		}
		return json_encode($result);
	}

	public function getMyCoupon(Request $request){
		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else{
			$user = User::find($ltoken->userId);

			if ($user == NULL){
				$result['success'] = false;
				$result['message'] = 'Please log in as a member';
			} else{
				$coupons = array();
				foreach ($user->coupons as $coupon) {
					$c = array(
						'cid'           => $coupon->id,
						'bid'           => $coupon->business->id,
						'bname'         => $coupon->business->name,
						'title'         => $coupon->title,
						'discount'      => $coupon->discount,
						'description'   => $coupon->description,
						'couponValue'   => $coupon->couponValueText,
						'disclaimer'    => $coupon->disclaimer,
                        'logo'          => '/Images/logos/' . $coupon->business->logoId . '.png'
                    );
					$coupons[] = $c;
				}
				$result['success'] = true;
				$result['message'] = 'Successfully fetched my coupon';
				$result['response'] = $coupons;
			}
		}
		return json_encode($result);
	}

	public function removeFromMyCoupon(Request $request){
		$cid = $request->input('cId');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else{
			$user = User::find($ltoken->userId);

			if ($user == NULL){
				$result['success'] = false;
				$result['message'] = 'Please log in as a member';
			} else {
				FrontHelper::removeFromMyCoupon($user->id, $cid);
				$result['success'] = true;
				$result['message'] = 'Removed coupon successfully';
			}
			
		}
		return json_encode($result);
	}

	public function setLocation(Request $request){
		$address = $request->input('address');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$r = FrontHelper::getCoordinate($address);
            $lat = $r->results[0]->geometry->location->lat;
            $lng = $r->results[0]->geometry->location->lng;

			$result['location'] = array(
				'lati' => $lat,
				'long' => $lng
				);

			$result['success'] = true;
			$result['message'] = 'Set location successfully';
		}
		return json_encode($result);
	}

	public function addToMyCoupon(Request $request){
		$cid = $request->input('cId');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$user = User::find($ltoken->userId);

			if ($user == NULL){
				$result['success'] = false;
				$result['message'] = 'Please log in as a member';
			} else {
				if (FrontHelper::addToMyCoupon($user->id, $cid)){
					$result['success'] = true;
					$result['message'] = 'Added coupon successfully';
				} else{
					$result['success'] = false;
					$result['message'] = 'The coupon is already added.';
				}
			}
		}
		return json_encode($result);
	}

	public function addReview(Request $request){
		$bid = $request->input('bId');
		$rating = $request->input('rating');
		$comment = $request->input('comment');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$user = User::find($ltoken->userId);

			if ($user == NULL){
				$result['success'] = false;
				$result['message'] = 'Please log in as a member';
			} else {
				$r = FrontHelper::addReview($bid, $user->id, $rating, $comment);
				if ($r == 0){
					$result['success'] = false;
					$result['message'] = "It appears that you have already submitted your rating for this business previously. Thank you!";
				} else if ($r == -1){
					$result['success'] = false;
					$result['message'] = "You haven't seen or downloaded this coupon.";
				} else if ($r == -2){
					$result['success'] = false;
					$result['message'] = "You've already submitted a complaint to this business.";
				} else{
					$result['success'] = true;
					if ($rating >= 3) {
						$result['message'] = "Your rating has been submitted successfully. Thank you!";
					} else{
						$result['message'] = "Your less than 3 Star rating has been submitted.  The business has 14 days to attempt to resolve any issues you may have.";
					}
				}
			}
		}
		return json_encode($result);
	}

	public function getConsumersGPS(Request $request){
		$group = $request->input('groupCategory');
		$cat = $request->input('category');
		$subcat = $request->input('subCategory');
		$rad = $request->input('radius');

		$lat = $request->input('lat', '');
		$lng = $request->input('lng', '');

		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();
		$r = [];

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Please login first';
		} else {
            if(empty($rad)) {
                $rad = 'national';
            }

            if ($lat == '' || $lng == '') {
                $lat = $ltoken->latitude;
                $lng = $ltoken->longitude;
                if ($lat == NULL || $lng == NULL){
                    $lat = 0; $lng = 0;
                }
            }

            $r = FrontHelper::filterBusiness($group, $cat, $subcat, $rad, $lat, $lng);
			$result['success']          = true;
			$result['message']          = 'Successfully fetched consumers';
            $result['rad']              = $rad;
			$result['consumers']        = $r['json'];
			$result['groupCategories']  = $r['groups'];
			$result['categories']       = $r['categories'];
			$result['subCategories']    = $r['subcats'];
			$result['groups']           = $r['tgroups'];
			$result['cats']             = $r['tcats'];
			$result['subcats']          = $r['tsubcats'];
		}
		return json_encode($result);
	}

	public function getConsumerDetail(Request $request){
		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$bId = $request->input('bId');
			$business = BusinessV::where('isDeleted', 0)->where('isActive', 1)->where('id', $bId)->first();
			$business->coupon = FrontHelper::currentCoupon($business->coupons);
			if ($business == NULL){
				$result['success'] = false;
				$result['message'] = 'No such business';
			} else{
				$result['response'] = array('consumer' => $business);
				$result['success'] = true;
				$result['message'] = 'Successfully fetched consumer detail';
			}
		}
		return json_encode($result);
	}

	public function getBusinessReview(Request $request){
		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$bId = $request->input('bId');

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$business = BusinessV::where('isDeleted', 0)->where('isActive', 1)->where('id', $bId)->first();
			if ($business == NULL){
				$result['success'] = false;
				$result['message'] = 'No such business';
			} else{
				$result['success']  = true;
				$result['message']  = 'Successfully fetched consumer detail';
                $result['value']    = $business->ratings;
			}
		}
		return json_encode($result);
	}

	public function getCoupon(Request $request){
		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$cId = $request->input('cId');

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Login, first';
		} else {
			$user = User::find($ltoken->userId);
			if ($user == NULL){
				$result['success'] = false;
				$result['message'] = 'Please login as a member';
			} else{
				$coupon = Coupon::find($cId);
				if ($coupon == NULL){
					$result['success'] = false;
					$result['message'] = 'No such coupon';
				} else {
					$ip = $request->ip();
					FrontHelper::viewCoupon($cId, $user->id, $ip);
					$result['success'] = true;
					$result['message'] = 'Successfully fetched coupon';
					$result['value'] = $coupon;
				}
			}
		}
		return json_encode($result);
	}

	public function changePassword(Request $request){
		$token = $request->input('token');
		$ltoken = $this->getLoginToken($token);

		$result = array();

		if ($ltoken == NULL){
			$result['success'] = false;
			$result['message'] = 'Please login first';
		} else {
			$user = User::find($ltoken->userId);

			$old = $request->input('oldPassword');
			$new = $request->input('newPassword');

			if (FrontHelper::changePassword($user, $old, $new)){
				$result['success'] = true;
				$result['message'] = 'Changed password successfully';
			} else {
				$result['success'] = false;
				$result['message'] = 'Wrong password';
			}
		}
		return json_encode($result);
	}

    public function checkInTerritory(Request $request) {
        $token = $request->input('token');
        $zipcode = $request->input('zipcode', '');

        $ltoken = $this->getLoginToken($token);
        if ($ltoken == NULL){
            $result['success'] = false;
            $result['message'] = 'Please login first';
        } else {
            if(empty($zipcode)) {
                if($ltoken->userId != 0) {
                    $user = User::find($ltoken->userId);
                    $zipcode = $user->zipcode;
                }
                else {
                    $zipcode = $ltoken->zipcode;
                }
            }
            $frZipcode = Zipcode::where('zipcode', $zipcode)->first();
            $result['success'] = true;
            $result['value'] = ($frZipcode != false);
        }

        return json_encode($result);
    }

    public function findBusiness(Request $request){
        $name = $request->input('name');
        $lat = $request->input('lat');
        $lng = $request->input('lng');
        $rad = $request->input('radius');

        $result = array();

        $token = $request->input('token');
        $ltoken = $this->getLoginToken($token);

        $result = array();
        $r = [];

        if ($ltoken == NULL){
            $result['success'] = false;
            $result['message'] = 'Please login first';
        } else {
            if(empty($rad)) {
                $rad = 'national';
            }

            if ($lat == '' || $lng == '') {
                $lat = $ltoken->latitude;
                $lng = $ltoken->longitude;
                if ($lat == NULL || $lng == NULL){
                    $lat = 0; $lng = 0;
                }
            }

            $r = FrontHelper::findBusiness($name, $rad, $lat, $lng);

            $result['success'] = true;
            $result['message'] = 'Successfully fetched consumers';
            $result['consumers'] = $r['json'];
            $result['name'] = $name;
            $result['rad'] = $rad;
        }

        return json_encode($result);
    }

	public function test(){
		$user = User::where('email', 'like', 'songxunzhao1991@gmail.com')->first();
		
		MailHelper::sendWelcomeEmail($user);
		//MailHelper::sendActivationEmail($user);
        return json_encode('success');
	}


	private function getLoginToken($token){
		$token = LoginToken::where('token', $token)->first();
		if ($token != NULL){
			$token->lastSeen = date('Y-m-d H:m:s');
			$token->save();
		}
		return $token;
	}
}

?>