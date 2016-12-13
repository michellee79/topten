<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Page;
use App\Model\Business;
use App\Model\BusinessV;
use App\Model\TotalSaving;
use App\Model\Coupon;

use Auth;

use App\Helper\FrontHelper;
use App\MySession;

class HomeController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function index(){
		$totalSavings = intval(TotalSaving::find(1)->totalsavings);
		$totalUsers = User::where('isDeleted', 0)->count();
		$data = array(
			'totalSavings' => $totalSavings,
			'totalUsers' => $totalUsers,
			'user' => $this->user,
			'location' => $this->location,
			);
		return view('home', $data);
	}

    public function error404() {
        
    }

	public function signup(){
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			);
		if (MySession::getRegisterPromoStep() == 2){
			MySession::setRegisterPromoStep(1);
			return view('register_finish');
		}
		return view('register', $data);
	}

	public function login(Request $request){
		$redirect = $request->input('redirect');
		if ($redirect == NULL)
			$redirect = '';
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			'redirect' => $redirect,
			);
		return view('login', $data);
	}

	public function register_nominate(){    // Registration and nomination
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			);
		if (MySession::getRegisterNominationStep() == 2){
			return view('register_nominate_finish');
		}
		return view('register_nominate', $data);
	}

	public function register_from_nominate(){       // Registration after nominating 2 businesses
		if (Auth::guest()){
			$nCnt = MySession::get('nomination_cnt', 0);
			if ($nCnt < 1){
				return redirect('/registerandnominate');
			} else{
				$lastNominator = MySession::get('nominator');
				$data = array(
					'user' => $this->user,
					'location' => $this->location,
					'nominator' => $lastNominator
					);
				if (MySession::getRegisterNominationStep() == 2){
					return view('register_nominate_finish', $data);
				}
				return view('register_from_nominate', $data);
			}
		} else{
			return redirect('/registerandnominate');
		}
	}

	public function nominate($name = ''){
		$nCnt = MySession::get('nomination_cnt', 0) + 1;
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			'name' => $name,
			'nCnt' => $nCnt
			);
		return view('nominate', $data);
	}

	public function location(){
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
		);
		return view('location', $data);
	}

	public function change_password(){
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
		);
		return view('change_password', $data);
	}

	public function my_account(){
		$data = array(
			'user' => $this->user,
			'coupons' => $this->user->coupons,
			'location' => $this->location,
			);
		return view('myaccount', $data);
	}

	public function my_coupon(){
		$data = array(
			'user' => $this->user,
			'coupons' => $this->user->coupons,
			'location' => $this->location,
			);
		return view('mycoupons', $data);
	}

	public function business_list(){
		// $businesses = BusinessV::where('isActive', 1)
		// 					->where('isDeleted', 0)
		// 					->orderBy('averageValue', 'desc')
		// 					->get();
		$lat = MySession::getLatitude();
		$lng = MySession::getLongitude();
		if ($lat == NULL){
			return redirect('/setlocation');
		}
		$radius = 50;
		$businesses = FrontHelper::filterBusiness('', '', '', $radius, $lat, $lng);
		if (count($businesses['businesses']) == 0){
			$radius = 'national';
			$businesses = FrontHelper::filterBusiness('', '', '', $radius, $lat, $lng);
		}
		$data = array(
			'businesses' => $businesses['businesses'],
			'businessesJson' => escapeJsonString(json_encode($businesses['json'])),
			'groups' => $businesses['groups'],
			'user' => $this->user,
			'location' => $this->location,
			'lat' => $lat,
			'lng' => $lng,
			'radius' => $radius,
			);
		return view('businesses', $data);
	}

	public function business(Request $request, $id = ''){
		if ($id == ''){
			return redirect('/businesses');
		}
		
		$ip = $request->ip();
		if (Auth::guest()){
			FrontHelper::viewBusiness($id, NULL, $ip);
		} else{
			FrontHelper::viewBusiness($id, $this->user->id, $ip);
		}
		
		$business = BusinessV::find($id);
		if (substr(strtolower($business->website), 0, 4) != 'http')
			$business->website = 'http://' . $business->website;
		$images = array();
		$i = 0;
		foreach($business->images as $image){
			if ($i != 0) {
				$images[] = $image;
			}
			$i++;
		}
		$data = array(
			'business' => $business,
			'user' => $this->user,
			'images' => $images,
			'location' => $this->location,
			);
		return view('businessprofile', $data);
	}

	public function business_rating(Request $request, $id = ''){
		if ($id == ''){
			return redirect('/businesses');
		}
		$business = BusinessV::find($id);
		$data = array(
			'business' => $business,
			'user' => $this->user,
			'location' => $this->location,
			'renew' => false,
			);

		if ($request->input('renew') === 'true') {
			$data['renew'] = true;
		}

        $complaint_id = $request->input('complaint', '');
        if ($complaint_id !== '' ) {
            $complaint = Complaint::find($complaint_id);
            $complaint && ($complaint->isResolved = true) && $complaint->save();
        }
		return view('businessratings', $data);
	}

	public function coupon(Request $request, $id = ''){
		if ($id == ''){
			return redirect('businesses');
		}
		if (!Auth::guest()){
			$ip = $request->ip();
			FrontHelper::viewCoupon($id, $this->user->id, $ip);
		}
		$coupon = Coupon::find($id);
		$business = $coupon->business;
		$data = array(
			'business' => $business, 
			'coupon' => $coupon,
			'user' => $this->user,
			'location' => $this->location,
		);
		return view('coupon', $data);
	}

	public function page($name = ''){
		if ($name == ''){
			return redirect('/');
		}
		$name = strtolower($name);
		$data = array();
		if ($name == 'faq'){
			$pg = Page::where('pageName', 'FAQ')
				->first();
			$pgMobile = Page::where('pageName', 'FAQ-mobile')
				->first();
			$data = array(
				'content' => $pg->pageContent,
				'mcontent' => $pgMobile->pageContent,
				'user' => $this->user,
				'location' => $this->location,
				);
			$data['keyword'] = $pg->metaKeywords;
			$data['description'] = $pg->metaDescription;
		} else{
			$page = Page::where('pageName', $name)
				->first();
			$data = array(
				'content' => $page->pageContent,
				'mcontent' => $page->pageContent,
				'user' => $this->user,
				'location' => $this->location,
				);
			$data['keyword'] = $page->metaKeywords;
			$data['description'] = $page->metaDescription;
		}
		return view('page', $data);
	}

	public function activate($id=0){
		$success = false;
		if ($id != 0){
			$success = FrontHelper::activateUser($id);
		}
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			'success' => $success,
			);
		return view('activation', $data);
	}

	public function forgotPassword(){
		return view('forgot_password');
	}

	public function navigateToBusiness($id=0){
		if ($id == 0){
			return redirect('/businesses');
		}
	}

	public function confirmComplaint($id){
		$uid = $this->user->id;
		$result = FrontHelper::confirmComplaint($uid, $id);
		$data = array(
			'user' => $this->user,
			'location' => $this->location,
			'message' => $result['message'],
			);
		return view('confirm_complaint', $data);
	}

}

?>