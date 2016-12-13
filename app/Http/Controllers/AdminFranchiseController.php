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
use App\Model\State;

use Auth;

use App\Helper\FrontHelper;
use App\Helper\AdminHelper;
use App\MySession;

use Excel;

class AdminFranchiseController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function franchiseeList(){
		$franchisees = Franchisee::where('isDeleted', 0);
		$sort = MySession::get('admin_franchisees_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$franchisees = $franchisees->orderBy(substr($sort, 1), 'desc');
			} else{
				$franchisees = $franchisees->orderBy($sort);
			}
		}
		$franchisees = $franchisees->get();
		$states = State::all();
		$data = array(
			'franchisees' => $franchisees,
			'states' => $states,
			'sort' => $sort,
			);

		return view('admin.franchisee_list', $data);
	}

	public function getFranchiseeDetail($id){
		$franchisee = Franchisee::find($id);
		$result = array();
		if ($franchisee == NULL){
			$result['message'] = 'No such franchisee';
			$result['success'] = 'false';
		} else{
			$result['code'] = $franchisee->code;
			$result['name'] = $franchisee->name;
			$result['city'] = $franchisee->city;
			$result['state'] = $franchisee->state;
			$result['firstName'] = $franchisee->contactFirstName;
			$result['lastName'] = $franchisee->contactLastName;
			$users = $franchisee->users;
			$emails = array();
			foreach ($users as $user){
				$emails[] = $user->email;
			}
			$zipcodes = array();
			foreach($franchisee->zipcodes as $zipcode){
				$zipcodes[] = $zipcode->zipcode;
			}
			$result['zipcodes'] = implode("\n", $zipcodes);
			$result['emails'] = implode("\n", $emails);
			$result['firstName'] = $franchisee->contactFirstName;
			$result['lastName'] = $franchisee->contactLastName;
			$result['status'] = $franchisee->isActive;
			$result['launchStatus'] = $franchisee->isLaunched;
			$result['legalName'] = $franchisee->legalName;
			$result['streetAddress'] = $franchisee->streetAddress;
			$result['zipcode'] = $franchisee->franchiseZipcode;
			$result['showOnContract'] = $franchisee->showOnContract;
			$result['phone'] = $franchisee->phone;
			$result['lmGroup'] = $franchisee->lmGroup;
			$result['lmUser'] = $franchisee->lmUser;
			$result['lmPassword'] = $franchisee->lmPassword;
			$result['message'] = 'Fetched franchisee detail';
			$result['success'] = 'true';
		}
		return json_encode($result);
	}

	public function toggleFranchiseeActive($id){
		return json_encode(AdminHelper::toggleFranchiseeActive($id));
	}

	public function deleteFranchisee($id){
		return json_encode(AdminHelper::deleteFranchisee($id));
	}

	public function saveFranchisee(Request $request, $id){
		$params = array('code', 'name', 'city', 'state', 'zipcodes', 'firstName', 'lastName', 'emails', 'status', 'launchStatus', 'zipcode', 'legalName', 'streetAddress', 'showOnContract', 'phone', 'lmGroup', 'lmUsername', 'lmPassword');
		$values = array();
		foreach($params as $param){
			$values[$param] = $request->input($param);
		}
		$result = AdminHelper::saveFranchisee($id, $values);
		if ($result['success'] == 'true'){
			$franchisees = Franchisee::where('isDeleted', 0)->get();
			$sort = MySession::get('admin_franchisees_sort');
			$data = array(
				'franchisees' => $franchisees,
				'sort'=> $sort,
				);

			$result['html'] = view('components.admin.franchisees', $data)->render();
		}
		return json_encode($result);
	}

}

?>