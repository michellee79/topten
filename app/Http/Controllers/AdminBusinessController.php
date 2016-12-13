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

class AdminBusinessController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function manageBusinessSelections(){
		$franchisees = Franchisee::where('isDeleted', 0)
								->where('code', '<>', 'Top Ten Percent')
								->orderBy('name')
								->get();
		$fid = MySession::get('admin_business_franchise_filter', 0);

		$businessSelections = BusinessSelection::where('isDeleted', 0)
											->whereNotNull('passed');

		if ($fid > 0){
			$businessSelections = $businessSelections->where('franchiseId', $fid);
		}
		$sort = MySession::get('admin_businessselectionlist_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$businessSelections = $businessSelections->orderBy(substr($sort, 1), 'desc');
			} else{
				$businessSelections = $businessSelections->orderBy($sort);
			}
		}
		$businessSelections = $businessSelections->orderBy('businessName')->get();
		$data = array(
			'franchisees' => $franchisees,
			'businessSelections' => $businessSelections,
			'fid' => $fid,
			'sort' => $sort,
			);
		return view('admin.manage_business_selections', $data);
	}

	public function setFilterFranchise($id){
		MySession::set('admin_business_franchise_filter', $id);
	}

}

?>