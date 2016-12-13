<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Zipcode;
use App\Model\USCity;
use App\Model\BusinessV;
use App\Model\TotalSaving;
use App\Model\Coupon;
use App\Model\BusinessWebsiteView;

use App\Helper\FrontHelper;
use App\MySession;

use App\Helper\CronHelper;

use Auth;

class AjaxController extends Controller{

	public function getlocations(Request $request){
		$str = $request->input('q');

		$locations = FrontHelper::getlocations($str);
		$result = '';

		foreach ($locations as $location) {
			$result .= $location . "\r\n";
		}

		return $result;
	}

	public function filterBusiness(Request $request){
		$result = array();
		$user = Auth::user();
		
		$group = $request->input('group');
		$cat = $request->input('category');
		$subcat = $request->input('subcategory');
		$group2 = $request->input('group2');
		$cat2 = $request->input('category2');
		$subcat2 = $request->input('subcategory2');
		$rad = $request->input('radius');

		$lat = MySession::getLatitude();
		$lng = MySession::getLongitude();
		if ($lat == NULL){
			$lat = 0; $lng = 0;
		}

		$businesses = FrontHelper::filterBusiness($group, $cat, $subcat, $rad, $lat, $lng);
		$data = array(
			'businesses' => $businesses['businesses'],
			'user' => $user,
			);
		$result['success'] = 'true';
		$result['message'] = 'Businesses are fetched succeessfully.';
		$result['render'] = view('components.businesses', $data)->render();
		$result['renderMobile'] = view('components.businesses_mobile', $data)->render();
		$result['categories'] = $businesses['categories'];
		$result['subcategories'] = $businesses['subcats'];
		$result['businessesJson'] = json_encode($businesses['json'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);

		return json_encode($result);
	}

	public function findBusiness($radius, $name=''){
		$result = array();

		$lat = MySession::getLatitude();
		$lng = MySession::getLongitude();
		if ($lat == NULL){
			$lat = 0; $lng = 0;
		}
		$user = Auth::user();

		$bresult = FrontHelper::findBusiness($name, $radius, $lat, $lng);
		$data = array(
			'businesses' => $bresult['businesses'],
			'user' => $user,
			);
		if (count($bresult['businesses']) > 0) {
			$result['success'] = 'true';
			$result['render'] = view('components.businesses', $data)->render();
			$result['renderMobile'] = view('components.businesses_mobile', $data)->render();
			$result['businessesJson'] = json_encode($bresult['json'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		} else {
			$result['success'] = 'false';
			$result['message'] = 'No business found.';
		}
		return json_encode($result);
	}

	public function addReview(Request $request){
		$result = array();
		if (Auth::guest()){
			$result['success'] = 'false';
			$result['message'] = 'Login first.';
		} else{
			$businessId = $request->input('bid');
			$userId = Auth::user()->id;
			$rating = $request->input('rating');
			$comment = $request->input('comment');
			$r = FrontHelper::addReview($businessId, $userId, $rating, $comment);
			if ($r == 0){
				$result['success'] = 'false';
				$result['message'] = "It appears that you have already submitted your rating for this business previously. Thank you!";
			} else if ($r == -1){
				$result['success'] = 'false';
				$result['message'] = "You haven't seen or downloaded this coupon.";
			} else if ($r == -2){
				$result['success'] = 'false';
				$result['message'] = "You've already submitted a complaint to this business.";
			} else{
				$business = BusinessV::find($businessId);
				$n = count($business->ratings);
				for ($i = 0; $i < $n; $i++) {
					if ($business->ratings[$i]->isDeleted == 1){
						unset($business->ratings[$i]);
					}
				}
				$data = array(
					'business' => $business,
					'user' => Auth::user(),
					);
				$result['success'] = 'true';
				if ($rating >= 3) {
					$result['message'] = "Your rating has been submitted successfully. Thank you!";
				} else{
					$result['message'] = "Your less than 3 Star rating has been submitted.  The business has 14 days to attempt to resolve any issues you may have.";
				}
				$result['render'] = view('components.ratings', $data)->render();
				$result['renderMobile'] = view('components.ratings_mobile', $data)->render();
			}
		}
		return json_encode($result);
	}

	public function addToMyCoupon(Request $request){
		$result = array();
		if (Auth::guest()){
			$result['success'] = 'false';
			$result['message'] = 'Please login first.';
		} else{
			$couponId = $request->input('cid');
			$coupon = Coupon::find($couponId);
			$userId = Auth::user()->id;
			$r = FrontHelper::addToMyCoupon($userId, $couponId);
			if ($r == 1){
				$result['success'] = 'true';
				$result['message'] = 'Coupon was added successfully.';
				$result['coupon'] = $coupon->business->name;
			} else{
				$result['success'] = 'false';
				$result['message'] = 'Unable to save! <br/>Coupon was found in your saved list.';
			}
		}
		return json_encode($result);
	}

	public function removeFromMyCoupon(Request $request){
		$result = array();
		if (Auth::guest()){
			$result['success'] = 'false';
			$result['message'] = 'Please login first.';
		} else{
			$couponId = $request->input('cid');
			$userId = Auth::user()->id;
			FrontHelper::removeFromMyCoupon($userId, $couponId);
			$user = Auth::user();
			$data = array(
				'user' => $user,
				'coupons' => $user->coupons,
				);
			$result['render'] = view('components.mycoupons', $data)->render();
			$result['renderMobile'] = view('components.mycoupons_mobile', $data)->render();
			$result['success'] = 'true';
			$result['message'] = 'Coupon has been removed from your account list.';
		}
		return json_encode($result);
	}

	public function updateMyAccount(Request $request){
		$result = array();
		if (Auth::guest()){
			$result['success'] = 'false';
			$result['message'] = 'Please login first.';
		} else{
			$user = Auth::user();
			$fname = $request->input('fname');
			$lname = $request->input('lname');
			$zipcode = $request->input('zipcode');
			FrontHelper::updateAccount($user->id, $fname, $lname, $zipcode);
			MySession::setZipcode($zipcode);
			$result['success'] = 'true';
			$result['message'] = 'Your profile has been updated successfully.';
		}
		return json_encode($result);
	}

	public function changeLocation(Request $request){
		$result = array();
		$location = $request->input('location');
		try{
			if (MySession::setZipcode($location) == true) {
				$result['success'] = 'true';
				$result['message'] = 'Your location is temporarily changed.';
			} else{
				$result['success'] = 'false';
				$result['message'] = 'Error occured.';
			}
		} catch(\Exception $e){
			$result['success'] = 'false';
			$result['message'] = 'Error occured. ' . $e->getMessage();
		}
		return json_encode($result);
	}

	public function nominateBusiness(Request $request){
		$result = array();
			
		$name = $request->input('bname');
		$city = $request->input('bcity');
		$state = $request->input('bstate');
		$phone = $request->input('bphone');
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$email = $request->input('mail');
		$feel = $request->input('feel');
		$user = Auth::user();
		if ($name == '' || $fname == '' || $lname == '' || $email == '' || $feel == ''){
			$result['success'] = 'false';
			$result['message'] = 'Please complete all information.';
		} else{
			$zipcode = MySession::getZipcode();
			if ($zipcode == NULL && $user != NULL){
				$zipcode = $user->zipcode;
			}
			$f = FrontHelper::nominateBusiness($zipcode, $name, $city, $state, $phone, $fname, $lname, $email, $feel);
			$n = array(
				'firstName' => $fname,
				'lastName' => $lname,
				'email' => $email,
				'zipcode' => $zipcode
				);
			MySession::set('nominator', $n);
			$nCnt = MySession::get('nomination_cnt', 0) + 1;
			MySession::set('nomination_cnt', $nCnt);
			$result['success'] = 'true';
			if ($f != NULL)
				$result['franchisee'] = $f;
			else
				$result['franchisee'] == 0;
			$result['message'] = 'Successfully nominated a business';
			$result['count'] = $nCnt;
			$result['guest'] = Auth::guest();
		}
		return json_encode($result);
	}

	public function registerWithPromocode(Request $request){
		$result = array();
		$promo = $request->input('promo');
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$zipcode = $request->input('zipcode');
		$email = $request->input('email');
		$pswd = $request->input('password');
		if ($promo == '' || $fname == '' || $lname == '' || $zipcode == '' || $email == '' || $email == ''){
			$result['success'] = 'false';
			$result['message'] = 'Please complete all information.';
		} else{
			$r = FrontHelper::createUser($promo, $fname, $lname, $zipcode, $email, $pswd, true);
			if ($r == 1) {
				$result['success'] = 'true';
				$result['message'] = 'Successfully registered.';
				$result['redirect'] = '';
				MySession::setRegisterPromoStep(2);
			} else if ($r == 2){
				$result['success'] = 'true';
				$result['message'] = 'Successfully registered.';

				Auth::attempt(array('email' => $email, 'password' => $pswd));
				$user = Auth::user();
				if (MySession::getZipcode() == NULL){
					MySession::setZipcode($user->zipcode);
				}

				$result['redirect'] = '/';
			} else if ($r == -1){
				$result['success'] = 'false';
				$result['message'] = 'This email is already used.';
			} else{
				$result['success'] = 'false';
				$result['message'] = 'No such Promocode.';
			}
		}
		return json_encode($result);
	}

	public function registerWithNomination(Request $request){
		$result = array();
		$fname = $request->input('fname');
		$lname = $request->input('lname');
		$zipcode = $request->input('zip');
		$email = $request->input('email');
		$pswd = $request->input('password');

		$name1 = $request->input('bname1');
		$city1 = $request->input('bcity1');
		$state1 = $request->input('bstate1');
		$phone1 = $request->input('bphone1');
		$reason1 = $request->input('breason1');

		$name2 = $request->input('bname2');
		$city2 = $request->input('bcity2');
		$state2 = $request->input('bstate2');
		$phone2 = $request->input('bphone2');
		$reason2 = $request->input('breason2');

		if ($fname == '' || $lname == '' || $zipcode == '' || $email == '' || $name1 == '' || $name2 == '' || $city1 == '' || $city2 == '' || $state1 == '' || $state2 == '' || $reason1 == '' || $reason2 == ''){
			$result['success'] = 'false';
			$result['message'] = 'Please complete all information.';
			$result['params'] = $fname . $lname . $zipcode . $email . $name1 . $name2 . $city1 . $city2 . $state1 . $state2 . $reason1 . $reason2;
		} else{
			FrontHelper::nominateBusiness($zipcode, $name1, $city1, $state1, $phone1, $fname, $lname, $email, $reason1);
			FrontHelper::nominateBusiness($zipcode, $name2, $city2, $state2, $phone2, $fname, $lname, $email, $reason2);
			if (FrontHelper::createUser(NULL, $fname, $lname, $zipcode, $email, $pswd, true) > 0){
				$result['success'] = 'true';
				$result['message'] = 'Successfully registered.';
				MySession::setRegisterNominationStep(2);

				if (Auth::guest()){
					Auth::attempt(array('email' => $email, 'password' => $pswd));
					$user = Auth::user();
					if (MySession::getZipcode() == NULL)
						MySession::setZipcode($user->zipcode);
				}
			} else{
				$result['success'] = 'false';
				$result['message'] = 'The email is already used.';
			}
		}		
		return json_encode($result);
	}

    public function registerFromNomination(Request $request){
        $result = array();
        $fname = $request->input('fname');
        $lname = $request->input('lname');
        $zipcode = $request->input('zip');
        $email = $request->input('email');
        $pswd = $request->input('password');

        if ($fname == '' || $lname == '' || $zipcode == '' || $email == ''){
            $result['success'] = 'false';
            $result['message'] = 'Please complete all information.';
            $result['params'] = $fname . $lname . $zipcode . $email;
        } else{
            if (FrontHelper::createUser(NULL, $fname, $lname, $zipcode, $email, $pswd, true) > 0){
                $result['success'] = 'true';
                $result['message'] = 'Successfully registered.';
                MySession::setRegisterNominationStep(2);

                if (Auth::guest()){
                    Auth::attempt(array('email' => $email, 'password' => $pswd));
                    $user = Auth::user();
                    if (MySession::getZipcode() == NULL)
                        MySession::setZipcode($user->zipcode);
                }
            } else{
                $result['success'] = 'false';
                $result['message'] = 'The email is already used.';
            }
        }
        return json_encode($result);
    }

	public function getTotal(){
		$totalSavings = TotalSaving::find(1)->totalsavings;
		$totalUsers = User::where('isDeleted', 0)->count();
		$data = array(
			'totalSavings' => intval($totalSavings),
			'totalUsers' => $totalUsers,
			);
		return json_encode($data);
	}

	public function visitBusinessWebsite(Request $request, $id){
		$ip = $request->ip();
		$user = Auth::user();
		if (Auth::guest()){
			FrontHelper::viewWebsite($id, NULL, $ip);
		} else{
			FrontHelper::viewWebsite($id, $user->id, $ip);
		}
	}

	public function syncTest(){
		CronHelper::syncUsers();
	}

}

?>