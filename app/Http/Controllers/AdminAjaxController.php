<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Zipcode;
use App\Model\USCity;
use App\Model\BusinessV;
use App\Model\Page;
use App\Model\Franchisee;

use App\Helper\FrontHelper;
use App\Helper\AdminHelper;
use App\Helper\FranchiseHelper;
use App\MySession;

use Auth;

class AdminAjaxController extends Controller{

	public function saveNews(Request $request){
		$content = $request->input('content');
		AdminHelper::savePage(14, 'Franchise Dashboard', $content, 'Top Ten Percent Franchise Dashboard', 'Top Ten Percent Franchise Dashboard');
	}

	public function savePage(Request $request, $id){
		$content = $request->input('content');
		$name = $request->input('pageTitle');
		$keyword = $request->input('metaKeyword');
		$description = $request->input('metaDescritpion');
		$active = $request->input('isActive');
		AdminHelper::savePage($id, $name, $content, $keyword, $description, $active);
	}

	public function deletePage($id){
		AdminHelper::deletePage($id);
	}

	public function saveContract(Request $request){
		$content = $request->input('content');
		$title = $request->input('title');
		$active = $request->input('isActive');
		$enterprise = $request->input('enterprise');
		$corporation = $request->input('corporation');
		AdminHelper::saveContract($title, $content, $active, $enterprise, $corporation);
	}

	public function togglePromoNeedActivation($id){
		return json_encode(FranchiseHelper::togglePromoNeedActivation($id));
	}

	public function togglePromoActivation($id){
		return json_encode(FranchiseHelper::togglePromoActivation($id));
	}

	public function deletePromo($id){
		return json_encode(FranchiseHelper::deletePromo($id));
	}

	public function createPromo(Request $request){
		$result = array();
		$params = array('code', 'assignedTo', 'requireActivation');

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
		$code = $request->input('code');
		$code3 = substr($code, 0, 3);
		if (Franchisee::where('code', $code3)->where('isDeleted', 0)->count() == 0){
			$result['success'] = 'false';
			$result['message'] = "No such franchisee whose code is $code3";
		} else{
			$result = FranchiseHelper::addPromo($values);
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

}

?>