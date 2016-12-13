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

use Excel;

class AdminNominationController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}


	public function manageNominations(){
		$franchisees = Franchisee::where('isDeleted', 0)
								//->where('code', '<>', 'Top Ten Percent')
								->orderBy('name')
								->get();
		$nominations = NominatedBusiness::where('isDeleted', '<>', 1);
		$avalue = MySession::get('admin_nomination_approval_filter', 2);
		if ($avalue < 2){
			$nominations = $nominations->where('isApproved', $avalue);
		}

		$fid = MySession::get('admin_nomination_franchisee_filter', 0);
		if ($fid > 0){
			$nominations = $nominations->where('franchiseId', $fid);
		}

		$sort = MySession::get('admin_nomination_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$nominations = $nominations->orderBy(substr($sort, 1), 'desc');
			} else{
				$nominations = $nominations->orderBy($sort);
			}
		}
		$nominations = $nominations->paginate(20);
		$data = array(
			'nominations' => $nominations,
			'avalue' => $avalue,
			'sort' => $sort,
			'franchisees' => $franchisees,
			'fid' => $fid,
			);
		return view('admin.manage_nominations', $data);
	}

	public function setFilterApproval($code){
		MySession::set('admin_nomination_approval_filter', $code);
	}

	public function setFilterFranchisee($code){
		MySession::set('admin_nomination_franchisee_filter', $code);
	}

	public function toggleNominationApproval($id){
		return json_encode(AdminHelper::toggleNominationApproval($id));
	}

	public function deleteNomination($id){
		return json_encode(AdminHelper::deleteNomination($id));
	}

}

?>