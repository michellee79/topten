<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\Franchisee;
use App\Model\BusinessV;

use Auth;

use App\Helper\AdminHelper;
use App\Helper\FranchiseHelper;

use App\MySession;

use TCPDF;

class FranchisorReportController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function report(){
		$franchisee = Franchisee::where('isDeleted', 0)->where('id', $this->user->franchiseId)->first();
		if ($this->user->role == 2){
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
		}
		$businessCnt = $franchisee->businesses()->where('isDeleted', 0)->where('isActive', 1)->count();
		$totalBusinessCnt = Business::where('isDeleted', 0)->where('isActive', 1)->count();
		$totalUsers = User::where('fid', $franchisee->id)->where('isDeleted', 0)->where('isActivated', 1)->count();

		$consumerCnt = User::where('isDeleted', 0)->count();
		$data = array(
			'franchisee' => $franchisee,
			'businessCnt' => $businessCnt,
			'nationalConsumerTotal' => $consumerCnt,
			'totalBusinessCnt' => $totalBusinessCnt,
			'totalUsers' => $totalUsers,
			'business' => NULL,
			'start' => 0,
		);
		return view('franchisor.report', $data);
	}

	public function businessReport($id = 0){
		if ($id == 0){
			return redirect('/franchise_businesses');
		}
		$business = Business::find($id);
		$data = array(
			'business' => $business,
			);
		return view('franchisor.business_report', $data);
	}

	public function pdfReport(Request $request){
		$start = $request->input('start');
		$end = $request->input('end');
		$businessName = $request->input('business');

		$franchisee = Franchisee::where('isDeleted', 0)->where('id', $this->user->franchiseId)->first();
		if ($this->user->role == 2){
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
		}
		$business = $franchisee->businessVs()->where('isDeleted', 0)->where('name', 'like', $businessName . '%')->first();
		$businessesInSameCat = 0;
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

		foreach ($business->coupons as $coupon){
			$downloads += $coupon->couponViews()->where('viewedDate', '>=', $start)->where('viewedDate', '<=', $end)->count();
		}
		
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
			'coupon' => currentCoupon($business->coupons),
			'start' => $start,
			'end' => $end,
		);

		if ($business != NULL) {
			$businessName = $business->name;
		}

		$html = view('components.franchisor.pdf_report', $data)->render();

		$pdf = new TCPDF;
		$pdf->setTitle('Franchise Report - ' . $businessName . ' From '. $start . ' To ' . $end);
		$pdf->addPage();
		$pdf->writeHTML($html);
		$filename = 'FranchiseReport-' . date('YmdHis') . '.pdf';
		$pdf->output(public_path() . '/tmp/'. $filename, 'F');

		$result = array(
			'success' => 'true',
			'file' => $filename,
			);
		$result['message'] = "Successfully calculated.";
		$result['html'] = view('components.franchisor.report', $data)->render();
		if ($business != NULL) {
			$result['businessName'] = $business->name;
		} else{
			$result['businessName'] = $businessName;
		}
		return json_encode($result);
	}

	public function downloadPdf($name){
		$file = public_path() . '/tmp/' . $name;
		//if (file_exists($file)){
			$headers = array(
				'Content-Type: application/pdf',
				
				);
			return response()->download($file, $name, $headers);
		//}
		//return "";
	}

	public function getBusinessNames(Request $request){
		$str = $request->input('q');
		
		$franchisee = Franchisee::where('isDeleted', 0)->where('id', $this->user->franchiseId)->first();
		if ($this->user->role == 2){
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
		}

		$names = FranchiseHelper::getBusinessNames($franchisee->id, $str);
		$result = '';

		foreach ($names as $name) {
			$result .= $name . "\r\n";
		}

		return $result;
	}
	
}

?>