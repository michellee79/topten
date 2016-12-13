<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\BusinessV;
use App\Model\NominatedBusiness;
use App\Model\Promo;
use App\Model\Franchisee;
use App\Model\BusinessSelection;
use App\Model\GalleryImage;
use App\Model\BusinessCategory;
use App\Model\State;
use App\Model\BusinessContract;
use App\Model\Contract;
use App\Model\Industry;
use App\Model\Page;

use Auth;

use App\Helper\AdminHelper;
use App\Helper\FranchiseHelper;
use App\MySession;

class FranchisorController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function home(Request $request){
		$user = Auth::user();
		$nominations = NominatedBusiness::where('isDeleted', '<>', 1);

		// if ($user->role == 2){
		// 	$nominations = $nominations->whereNull('franchiseId');
		// } else{
		// 	$nominations = $nominations->where('franchiseId', $user->franchiseId);
		// }
		$nominations = $nominations->where('franchiseId', $user->franchiseId);
		$hasFilter = $sort = $fname = $femail = $fsubmitted1 = $fsubmitted2 = $approval = '';

		if (MySession::get('prev_context', '') == $request->path()) {
			$approval = MySession::get('franchise_home_approved', 3);
			if ($approval != 3){
				$nominations = $nominations->where('isApproved', $approval);
			}

			$fname = MySession::get('franchise_dashboard_filter_businessName', '');
			$femail = MySession::get('franchise_dashboard_filter_email', '');
			$fsubmitted1 = MySession::get('franchise_dashboard_filter_dateSubmitted_from', '');
			$fsubmitted2 = MySession::get('franchise_dashboard_filter_dateSubmitted_to', '');

			if ($fname != '' || $femail != ''){
				$hasFilter = true;
			}

			$nominations = $nominations->where('businessName', 'like', '%' . $fname . '%')
									->where('email', 'like', '%' . $femail . '%');

			if ($fsubmitted1 != ''){
				$nominations = $nominations->where('dateSubmitted', '>=', \DateTime::createFromFormat('m/d/Y', $fsubmitted1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($fsubmitted2 != ''){
				$nominations = $nominations->where('dateSubmitted', '<=', \DateTime::createFromFormat('m/d/Y', $fsubmitted2)->format('Y-m-d'));
				$hasFilter = true;
			}

			$sort = MySession::get('franchise_home_sort');
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$nominations = $nominations->orderBy(substr($sort, 1), 'desc');
				} else{
					$nominations = $nominations->orderBy($sort);
				}
			}
		}

		$news = Page::find(14)->pageContent;

		$filters = array(
			'columns' => ['businessName', 'email', 'dateSubmitted_from', 'dateSubmitted_to'],
			'filters' => [
				['name' => 'businessName', 'text' => 'Business Name', 'type' => 'text', 'value' => $fname],
				['name' => 'email', 'text' => 'Email', 'type' => 'text', 'value' => $femail],
				['name' => 'dateSubmitted', 'text' => 'Submission Date', 'type' => 'date', 'value' => $fsubmitted1 . ',' . $fsubmitted2],
			],
			'scope' => 'franchise_dashboard',
		);

		$nominations = $nominations->paginate(20);
		$data = array(
			'nominations' => $nominations,
			'approval' => $approval,
			'user' => $user,
			'news' => $news,
			'sort' => $sort,
			'filters' => $filters,
			'hasFilter' => $hasFilter,
			);
		return view('franchisor.dashboard', $data);
	}

	public function roiCalculator(){
		$industries = Industry::all();
		$data = array(
			'industries' => $industries,
			);
		return view('franchisor.roi_calculator', $data);
	}

	public function roiCalculatorHelp(){
		return view('franchisor.roi_calculator_help');
	}


	// Ajax processing for view settings
	public function setApproval($val){
		MySession::set('franchise_home_approved', $val);
	}

	public function toggleNominationApproval($id){
		return json_encode(AdminHelper::toggleNominationApproval($id));
	}

	public function deleteNomination($id){
		return json_encode(AdminHelper::deleteNomination($id));
	}

	public function businessCriteria($id=0){
		$business = NULL;
		for ($i = 1; $i < 10; $i++){
			$s[$i] = 0;
		}
		$val = 0;
		$data = array(
			'businessName' => '',
			'consumerNominated' => '',
			'businessContact' => '',
			'businessContact2' => '',
			'businessPhone' => '',
			'businessZip' => '',
			'id' => $id,
			);
		if ($id > 0){
			$bs = BusinessSelection::find($id);

			$s[1] = $bs->siteInspection;
			$s[2] = $bs->interview;
			$s[3] = $bs->missionStatement;
			$s[4] = $bs->communityInvolvement;
			$s[5] = $bs->achievements;
			$s[6] = $bs->yearsInBusiness;
			$s[7] = $bs->bbbMembership;
			$s[8] = $bs->onlineCustomerReviews;
			$s[9] = $bs->chamberOfCommerce;

			$data['businessName'] = $bs->businessName;
			$data['consumerNominated'] = $bs->consumerNominated;
			$data['businessContact'] = $bs->businessContact;
			$data['businessContact2'] = $bs->businessContact2;
			$data['businessPhone'] = $bs->businessPhone;
			$data['businessZip'] = $bs->businessZip;
		}
		for ($i = 1; $i < 10; $i++){
			$val += $s[$i];
			$data['s' . $i] = $s[$i];
		}
		$data['val'] = $val;
		return view('franchisor.business_criteria', $data);
	}

	public function saveBusinessCriteria(Request $request, $id){
		$sum = 0;
		if ($id == 0){
			$franchiseId = $this->user->franchiseId;
			$businessName = $request->input('businessName');
			$consumerName = $request->input('consumerName');
			$businessContactName = $request->input('businessContactName');
			$businessContactName2 = $request->input('businessContactName2');
			$phoneNumber = $request->input('businessPhoneNumber');
			$zipcode = $request->input('zipcode');
			$id = FranchiseHelper::saveBusinessCriteria($franchiseId, $businessName, $consumerName, $businessContactName, $businessContactName2, $phoneNumber, $zipcode);
		} else {
			$inspection = $request->input('inspection');
			$interview = $request->input('interview');
			$mission = $request->input('mission');
			$community = $request->input('community');
			$achievement = $request->input('achievement');
			$years = $request->input('years');
			$bbb = $request->input('bbb');
			$review = $request->input('review');
			$chamber = $request->input('chamber');
			$sum = FranchiseHelper::updateBusinessCriteria($id, $inspection, $interview, $mission, $community, $achievement, $years, $bbb, $review, $chamber);
		}
		$result = array(
			'success' => 'true',
			'id' => $id,
			'sum' => $sum,
			);
		return json_encode($result);
	}
}

?>