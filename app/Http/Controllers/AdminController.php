<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\NominatedBusiness;
use App\Model\Promo;
use App\Model\Franchisee;
use App\Model\BusinessSelection;
use App\Model\GalleryImage;
use App\Model\BusinessCategory;
use App\Model\Page;
use App\Model\Contract;

use Auth;

use App\Helper\FrontHelper;
use App\Helper\AdminHelper;
use App\MySession;
use App\Helper\MailHelper;

use Excel;

class AdminController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function testEmail(){
		MailHelper::sendTestEmail();
	}

	public function report(){
		$franchisees = Franchisee::where('isDeleted', 0)->get();
		$businessCnt = Business::where('isDeleted', 0)->where('isActive', 1)->count();
		$consumerCnt = User::where('isDeleted', 0)->count();
		$data = array(
			'franchisees' => $franchisees,
			'businessTotal' => $businessCnt,
			'consumerTotal' => $consumerCnt,
			'start' => 0,
			'code' => '',
		);
		return view('admin.report', $data);
	}

	public function ajaxReport(Request $request){
		$result = array();

		$start = $request->input('start');
		$end = $request->input('end');
		$code = $request->input('code');
		$user = Auth::user();
		$franchisees = Franchisee::where('isDeleted', 0);//->get();
		if ($code != ''){
			$franchisees = $franchisees->where('code', $code);
		}
		$businessCnt = 0;
		$consumerCnt = 0;
		if ($start !== 0){
			$businessCnt = Business::where('isDeleted', 0)->where('isActive', 1)->where('dateCreated', '>=', $start)->where('dateCreated', '<=', $end)->count();
			$consumerCnt = User::where('isDeleted', 0)->whereNotNull('promoCode')->where('isActivated', 1)->where('createdDate', '>=', $start)->where('createdDate', '<=', $end)->count();
		} else {
			$businessCnt = Business::where('isDeleted', 0)->where('isActive', 1)->count();
			$consumerCnt = User::where('isDeleted', 0)->count();
		}
		$data = array(
			'franchisees' => $franchisees->get(),
			'businessTotal' => $businessCnt,
			'consumerTotal' => $consumerCnt,
			'start' => $start,
			'end' => $end,
			'code' => $code,
		);
		$result['success'] = 'true';
		$result['message'] = "Successfully calculated.";
		$result['html'] = view('components.admin.report', $data)->render();

		return json_encode($result);
	}

}

?>