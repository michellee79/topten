<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Zipcode;
use App\Model\USCity;
use App\Model\BusinessV;
use App\Model\Business;
use App\Model\Complaint;
use App\Model\Rating;
use App\Model\Coupon;
use App\Model\Franchisee;
use App\Model\Promo;
use App\Model\GalleryImage;
use App\Model\BusinessContract;

use App\Helper\FrontHelper;
use App\Helper\AdminHelper;
use App\Helper\FranchiseHelper;
use App\Helper\MailHelper;

use App\MySession;

use Auth;

class FranchiseAjaxController extends Controller{

	public function saveBusiness(Request $request, $id){
		$result = array();
		
		$franchiseId = $request->input('franchise');
		$catId = $request->input('catId');
		$catId2 = $request->input('catId2');
		$bname = $request->input('bname');
		$addr = $request->input('address');
		$city = $request->input('city');
		$state = $request->input('state');
		$zipcode = $request->input('zipcode');
		$cfname = $request->input('cfname');
		$clname = $request->input('clname');
		$cemail = $request->input('cemail');
		$cwebsite = $request->input('cwebsite');
		$cphone = $request->input('cphone');
		$ccphone = $request->input('ccphone');
		$sdate = $request->input('sdate');
		$active = $request->input('active');
		if (\Input::hasFile('image'))
			$image = \Input::file('image');
		else 
			$image = NULL;
		$trtext = $request->input('trtext');
		$bltext = $request->input('bltext');
		$summary = $request->input('summary');
		$id = $request->input('bid');
		$r = FranchiseHelper::saveBusiness($franchiseId, $catId, $catId2, $bname, $addr, $city, $state, $zipcode, 
			$cfname, $clname, $cemail, $cwebsite, $cphone, $ccphone, $sdate, $active, $image, $trtext, $bltext, $summary, $id);

		return json_encode($r);
	}

	public function removeBusiness(Request $request, $id){
		$result = array();

		$r = FranchiseHelper::removeBusiness($id);
		if ($r == 0){
			$result['success'] = 'false';
			$result['message'] = "No such business.";
		} else {
			$result['success'] = 'true';
			$result['message'] = "Deleted a business successfully.";
		}
		return json_encode($result);
	}

	public function saveContract(Request $request){
		$result = array();
		
		$params = array(
			'businessId', 'name', 'email', 'website', 'effectiveDate', 'address', 'city', 'state', 'zip', 'phone', 'fax', 
			'authorizedRep', 'repTitle', 'subCatId', 'subCatId2', 'additionalInstructions', 'initialCoupon', 'averageTransaction', 'averageDeterminedValue',
			'visibleOnWebsite', 'paymentDueDate', 'paymentType', 'membershipType', 'membershipFee', 'initialFeeType', 'fee',
			'other1', 'other2', 'note', 'totalDueNow', 'onGoingMonthlyFee', 'businessMemberSignature', 'topTenRepSignature','vip', 'promo');
		$values = array();
		foreach ($params as $param){
			if (!$request->has($param)){
				$result['success'] = 'false';
				$result['message'] = 'Bad Input';
			}
			$values[$param] = $request->input($param);
		}
		$r = FranchiseHelper::saveContract($values);
		$result['success'] = $r['success'];
		$result['message'] = $r['message'];
		return json_encode($result);
	}

	public function getComplaint($id){
		$result = array();

		$complaint = Complaint::find($id);
		if ($complaint == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such complaint";
		} else{
			$result['id'] = $complaint->id;
			$result['firstName'] = $complaint->user->firstName;
			$result['lastName'] = $complaint->user->lastName;
			$result['email'] = $complaint->user->email;
			$result['rating'] = $complaint->rating;
			$result['comment'] = $complaint->comment;
            $result['submitted'] = $complaint->submitted_on;
    		$result['isResolved'] = $complaint->isResolved;
            $result['isPublished'] = $complaint->isPublished;
		}
		return json_encode($result);
	}

	public function sendContractEmail($id){
		$result = array();

		$bc = BusinessContract::where('businessId', $id)->where('isDeleted', 0)->first();
		if ($bc == NULL){
			$result['success'] = 'false';
			$result['message'] = 'Bad request';
		} else {
			MailHelper::sendBusinessMembershipEmail($bc);
			$result['success'] = 'true';
			$result['message'] = 'Successfully sent email';
		}
		return json_encode($result);
	}

	public function saveComplaint(Request $request, $id){
		$result = array();

		$complaint = Complaint::find($id);
		if ($complaint == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such complaint";
		} else{
			$complaint->isResolved = $request->input('isResolved');
            $complaint->rating = $request->input('rating');
            $complaint->comment = $request->input('comment');
			$complaint->save();
			$result['success'] = 'true';
			$result['message'] = "Complaint has been resolved";
		}
		return json_encode($result);
	}

    public function deleteComplaint(Request $request, $id){
        $result = array();

        $complaint = Complaint::find($id);
        if ($complaint == NULL){
            $result['success'] = 'false';
            $result['message'] = "No such complaint";
        } else{
            $complaint->isDeleted = true;
            $complaint->save();
            $result['success'] = 'true';
            $result['message'] = "Complaint has been deleted";
        }
        return json_encode($result);
    }

	public function getRating($id){
		$result = array();

		$rating = Rating::find($id);
		if ($rating == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such rating";
		} else{
			$result['id'] = $rating->id;
			$result['firstName'] = $rating->user->firstName;
			$result['lastName'] = $rating->user->lastName;
			$result['rating'] = $rating->rating;
			$result['comment'] = $rating->comment;
    		$result['isDisplayed'] = $rating->isDisplayed;
		}
		return json_encode($result);
	}

	public function saveRating(Request $request, $id){
		$result = array();

		$rating = Rating::find($id);
		if ($rating == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such rating";
		} else{
			$rating->comment = $request->input('comment');
			$rating->save();
			$business = Business::find($rating->businessId);
			$ratings = array();
			foreach ($business->ratings as $rating) {
				if (!$rating->isDeleted){
					$ratings[] = $rating;
				}
			}
            $sort = MySession::get('franchise_businessratings_sort', '');
			$data = array(
				'business' => $business,
				'ratings' => $ratings,
                'sort' => $sort
				);
			$result['html'] = view('components.franchisor.ratings', $data)->render();
			$result['success'] = 'true';
			$result['message'] = "Updated a rating successfully";
		}
		return json_encode($result);
	}

	public function deleteRating($id){
		$result = array();

		$rating = Rating::find($id);
		if ($rating == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such rating";
		} else{
			FranchiseHelper::removeRating($id);
			$business = Business::find($rating->businessId);
			$ratings = array();
			foreach ($business->ratings as $rating) {
				if (!$rating->isDeleted){
					$ratings[] = $rating;
				}
			}
            $sort = MySession::get('franchise_businessratings_sort', '');
			$data = array(
				'business' => $business,
				'ratings' => $ratings,
                'sort' => $sort
				);
			$result['html'] = view('components.franchisor.ratings', $data)->render();
			$result['success'] = 'true';
			$result['message'] = 'Deleted a rating';
		}
		return json_encode($result);
	}

	public function activateRating($id){
		$result = array();

		$rating = Rating::find($id);
		if ($rating == NULL){
			$result['success'] = 'false';
			$result['message'] = "No such rating";
		} else{
			FranchiseHelper::activateRating($id);
			$business = Business::find($rating->businessId);
			
			$sort = MySession::get('franchise_businessratings_sort');
			$ratings = $business->ratings()->where('isDeleted', 0);
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$ratings = $ratings->orderBy(substr($sort, 1), 'desc');
				} else{
					$ratings = $ratings->orderBy($sort);
				}
			}
			$data = array(
				'business' => $business,
				'ratings' => $ratings->get(),
				'sort' => $sort,
				);
			$result['html'] = view('components.franchisor.ratings', $data)->render();
			$result['success'] = 'true';
			$result['message'] = 'Deleted a rating';
		}
		return json_encode($result);
	}

	public function uploadBusinessGalleryImage($id){
		$result = array();

		$file = \Input::file('image');
		$result = FranchiseHelper::saveBusinessGalleryImage($id, $file);
		$business = Business::find($id);
		$data = array(
			'business' => $business,
			);
		$result['html'] = view('components.franchisor.galleryimages', $data)->render();

		return json_encode($result);
	}

	public function deleteBusinessGalleryImage($bid, $gid){
		$result = array();

		FranchiseHelper::removeBusinessGalleryImage($bid, $gid);
		$business = Business::find($bid);

		$result['success'] = 'true';
		$result['message'] = "Deleted an image from business image gallery";
		$data = array(
			'business' => $business,
			);
		$result['html'] = view('components.franchisor.galleryimages', $data)->render();
		return json_encode($result);
	}

	public function saveCoupon(Request $request){
		$result = array();
		
		$paramNames = ['id','bid', 'title', 'description', 'discount', 'averageValue', 'disclaimer'];
		$paramValues = [];
		foreach ($paramNames as $key) {
			$paramValues[$key] = $request->input($key);
		}
		$result = FranchiseHelper::saveCoupon($paramValues);
		
		if ($result['success'] == 'true'){
			$business = Business::find($paramValues['bid']);

			$coupons = array();
			foreach ($business->coupons as $coupon) {
				if (!$coupon->isDeleted){
					$coupons[] = $coupon;
				}
			}
			$data = array(
				'business' => $business,
				'coupons' => $coupons,
				);
			$result['html'] = view('components.franchisor.coupons', $data)->render();
		}
		return json_encode($result);
	}

	public function getCoupon($id){
		$result = array();

		$coupon = Coupon::find($id);
		if ($coupon == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such coupon';
		} else{
			$result['success'] = 'true';
			$result['coupon'] = $coupon;
		}
		return json_encode($result);
	}

	public function activateCoupon($id){
		$result = array();
		
		$r = FranchiseHelper::activateCoupon($id);
		if ($r['success'] == 'true'){
			$coupon = Coupon::find($id);
			$business = $coupon->business;
			$coupons = array();
			foreach ($business->coupons as $coupon) {
				if (!$coupon->isDeleted){
					$coupons[] = $coupon;
				}
			}
			$data = array(
				'business' => $business,
				'coupons' => $coupons,
				);
			$r['html'] = view('components.franchisor.coupons', $data)->render();
		}
		return json_encode($r);
	}

	public function deleteCoupon($id){
		$result = array();
		
		$r = FranchiseHelper::deleteCoupon($id);
		if ($r['success'] == 'true'){
			$coupon = Coupon::find($id);
			$business = $coupon->business;
			$coupons = array();
			foreach ($business->coupons as $coupon) {
				if (!$coupon->isDeleted){
					$coupons[] = $coupon;
				}
			}
			$data = array(
				'business' => $business,
				'coupons' => $coupons,
				);
			$r['html'] = view('components.franchisor.coupons', $data)->render();
		}
		return json_encode($r);
	}

	public function businessReport(Request $request, $id){
		$result = array();

		$start = $request->input('start');
		$end = $request->input('end');
		$business = Business::find($id);
		$visits = $business->profileViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
		$downloads = 0;
		foreach ($business->coupons as $coupon){
			$downloads += $coupon->couponViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
		}
		$result['visits'] = $visits;
		$result['downloads'] = $downloads;
		$result['success'] = 'true';
		$result['message'] = 'Successfully calculated.';

		return json_encode($result);
	}

	public function franchiseReport(Request $request){
		$result = array();

		$start = $request->input('start');
		$end = $request->input('end');
		$businessName = $request->input('business');

		$user = Auth::user();
		$franchisee = Franchisee::where('isDeleted', 0)->where('id', $user->franchiseId)->first();
		if ($franchisee == NULL){
			$franchisee = Franchisee::where('name', 'National Account')->first();
		}
		$business = $franchisee->businessVs()->where('isDeleted', 0)->where('name', 'like', $businessName . '%')->first();
		$businessesInSameCat = [];
		$websiteVisits = 0;
		$pageVisits = 0;

		if ($business != NULL){
			$businessesInSameCat = BusinessV::where('ctGroup', $business->ctGroup)->where('isDeleted', 0)->where('isActive', 1)->get();
			$websiteVisits = $business->websiteViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
			$pageVisits = $business->profileViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
		}
		$businessViewsInSameCat = 0;
		
		$businessCnt = 0;
		$consumerCnt = 0;
		$downloads = 0;
		$activeUsers = 0;
		$totalUsers = 0;

        $activeUsers = User::where('fid', $franchisee->id)->where('isDeleted', 0)->where('isActivated', 1)->where('activationDate', '<=', $end)->where('activationDate', '>=', $start)->count();
        $totalUsers = User::where('fid', $franchisee->id)->where('isDeleted', 0)->where('isActivated', 1)->count();

        if($business)
        {
            foreach ($business->coupons as $coupon) {
                $downloads += $coupon->couponViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
            }
            $currentCoupon = currentCoupon($business->coupons);
        }
        else
            $currentCoupon = NULL;

		$businessCnt = $franchisee->businesses()->where('isDeleted', 0)->where('isActive', 1)->where('dateCreated', '>=', $start)->where('dateCreated', '<=', $end)->count();
		$consumerCnt = User::where('isDeleted', 0)->whereNotNull('promoCode')->where('isActivated', 1)->where('createdDate', '>=', $start)->where('createdDate', '<=', $end)->count();
		$nationalConsumerCnt = User::where('isDeleted', 0)->whereNotNull('promoCode')->count();
		foreach ($businessesInSameCat as $b){
			$businessViewsInSameCat += $b->profileViews()->where('viewedDate', '<=', $end)->where('viewedDate', '>=', $start)->count();
		}

		$totalBusinessCnt = Business::where('isDeleted', 0)->where('isActive', 1)->count();
		$data = array(
			'franchisee' => $franchisee,
			'businessCnt' => $businessCnt,
			'consumerTotal' => $consumerCnt,
			'activeUsers' => $activeUsers,
			'totalUsers' => $totalUsers,
			'nationalConsumerTotal' => $nationalConsumerCnt,
			'totalBusinessCnt' => $totalBusinessCnt,
			'businessViewsInSameCat' => $businessViewsInSameCat,
			'websiteVisits' => $websiteVisits,
			'pageVisits' => $pageVisits,
			'couponDownloads' => $downloads,
			'business' => $business,
			'coupon' => $currentCoupon,
			'start' => $start,
			'end' => $end,
		);
		$result['success'] = 'true';
		$result['message'] = "Successfully calculated.";
		$result['html'] = view('components.franchisor.report', $data)->render();
		if ($business != NULL) {
			$result['businessName'] = $business->name;
		} else{
			$result['businessName'] = $businessName;
		}

		return json_encode($result);
	}

	public function savePromo(Request $request, $id){
		$result = array();
		$name = $request->input('name');
		$user = Auth::user();
		$result = FranchiseHelper::updatePromo($id, $name);
		return json_encode($result);
	}

	public function addPromo(Request $request){
		$result = array();
		$params = array('code', 'assignedTo', 'requireActivation');
		$user = Auth::user();
		$values = array();
		foreach($params as $param){
			if ($request->has($param)){
				$values[$param] = $request->input($param);
			} else{
				$result['success'] = 'false';
				$result['message'] = 'Please fill all fields';
				return json_encode($result);
			}
		}
		if ($user->franchisee->code != substr($values['code'], 0, 3)){
			$result['success'] = 'false';
			$result['message'] = "Promo code must start with the your franchise code.";
		} else{
			$result = FranchiseHelper::addPromo($values);
		}
		return json_encode($result);
	}

	public function togglePromoNeedActivation($id){
		$user = Auth::user();
		$promo = Promo::find($id);
		$result = array();
		if ($user->franchisee->code != substr($promo->code, 0, 3)){
			$result['message'] = "You're not authorized to edit this promo code.";
			$result['success'] = 'true';
		} else{
			$result = FranchiseHelper::togglePromoNeedActivation($id);
		}

		return json_encode($result);
	}

	public function togglePromoActivation($id){
		$user = Auth::user();
		$promo = Promo::find($id);
		$result = array();
		if ($user->franchisee->code != substr($promo->code, 0, 3)){
			$result['message'] = "You're not authorized to edit this promo code.";
			$result['success'] = 'true';
		} else{
			$result = FranchiseHelper::togglePromoActivation($id);
		}
		return json_encode($result);
	}

	public function deletePromo($id){
		$user = Auth::user();
		$promo = Promo::find($id);
		$result = array();
		if ($user->franchisee->code != substr($values['code'], 0, 3)){
			$result['message'] = "You're not authorized to delete this promo code.";
			$result['success'] = 'true';
		} else{
			$result = FranchiseHelper::deletePromo($id);
		}
		return json_encode($result);
	}

	public function uploadGalleryImage(Request $request){
		$result = array();

		$file = \Input::file('image');
		$cat = $request->input('category');
		$result = FranchiseHelper::saveGalleryImage($file, $cat);
		$images = GalleryImage::where('category', '<>', 'N/A')->paginate(20);
		$data = array(
			'images' => $images,
			);
		$result['html'] = view('components.franchisor.images', $data)->render();
		
		return json_encode($result);
	}

	public function deleteGalleryImage($gid){
		$result = array();

		FranchiseHelper::removeGalleryImage($gid);
		
		$result['success'] = 'true';
		$result['message'] = "Deleted an image from business image gallery";

		$images = GalleryImage::where('category', '<>', 'N/A')->paginate(20);
		$data = array(
			'images' => $images,
			);
		$result['html'] = view('components.franchisor.images', $data)->render();
		
		return json_encode($result);
	}


	public function upload(){

        $file = \Input::file('image');

        $result = AdminHelper::uploadImage($file, 'upload');

        return json_encode($result);
	}

	public function imageList() {
        $imgList = array();
        $files = \File::allfiles(public_path().'/Images/upload');
        foreach ($files as $file) {
        	$title = str_replace(public_path(), '', $file);
        	$title = str_replace('\\', '/', $title);
            array_push($imgList, array("title"=>$title, "value"=>$title));
        }
        return json_encode($imgList);
    }

    public function setSortColumn($scope, $column){
    	$key = $scope . '_sort';
    	$val = MySession::get($key);
    	if ($val == $column){
    		$column = '-' . $column;
    	} else if ($val == '-' . $column){
    		$column = '';
    	}
    	MySession::set($key, $column);
    }

    public function setFilter(Request $request, $scope){
    	$columns = $request->input('columns');
    	$cols = explode(',', $columns);
    	foreach ($cols as $col){
    		$val = $request->input($col);
    		MySession::set($scope . '_filter_' . $col, $val);
    	}
    }

    public function sendActivationEmail($uid){
    	$user = User::find($uid);
    	$result = array();
    	if ($user == NULL){
    		$result['success'] = 'false';
    		$result['message'] = 'No such user';
    	} else{
    		MailHelper::sendActivationEmail($user);
    		$result['success'] = 'true';
    		$result['message'] = 'Activation email has been sent.';
    	}
    	return json_encode($result);
    }

    public function searchOOPDoc($phrase){

    	$url = "http://docs.toptenpercent.co/?json=get_search_results&search=" . urlencode($phrase);
		$response = file_get_contents($url);

		return $response;
    }

    public function getOOPDoc($id){

    	$url = "http://docs.toptenpercent.co/?json=get_post&post_id=" . $id;
		$response = file_get_contents($url);

		return $response;
    }

}

?>