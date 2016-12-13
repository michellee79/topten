<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\BusinessV;
use App\Model\Franchisee;
use App\Model\BusinessSelection;
use App\Model\GalleryImage;
use App\Model\State;
use App\Model\BusinessContract;
use App\Model\Contract;

use Auth;

use App\Helper\AdminHelper;
use App\MySession;
use App\Helper\FranchiseHelper;

class FranchisorBusinessController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function business(Request $request){

		if ($this->user->role == 1){
			$businesses = $this->user->franchisee->businesses()->where('isDeleted', 0);
		} else {
            /*
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
			$businesses = $franchisee->businesses()->where('isDeleted', 0);
            */
            $businesses = Business::where('isDeleted', 0);
		}

		$hasFilter = $sort = $fname = $fcity = $fzipcode = $fcreated1 = $fcreated2 = '';

		if (MySession::get('prev_context', '') == $request->path()) {
			$businesses = $businesses->where('name', 'like', $fname . '%')
								->where('city', 'like', $fcity . '%')
								->where('zipcode', 'like', $fzipcode . '%');

			$sort = MySession::get('franchise_businesslist_sort');

			$fname = MySession::get('franchise_businesslist_filter_name', '');
			$fcity = MySession::get('franchise_businesslist_filter_city', '');
			$fzipcode = MySession::get('franchise_businesslist_filter_zipcode', '');
			$fcreated1 = MySession::get('franchise_businesslist_filter_created_from', '');
			$fcreated2 = MySession::get('franchise_businesslist_filter_created_to', '');

			if ($fname != '' || $fcity != '' || $fzipcode != ''){
				$hasFilter = true;
				$businesses = $businesses->where('name', 'like', '%' . $fname . '%')->where('city', 'like', '%' . $fcity . '%')->where('zipcode', 'like', '%' . $fzipcode . '%');
			}

			if ($fcreated1 != ''){
				$businesses = $businesses->where('dateCreated', '>=', \DateTime::createFromFormat('m/d/Y', $fcreated1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($fcreated2 != ''){
				$businesses = $businesses->where('dateCreated', '<=', \DateTime::createFromFormat('m/d/Y', $fcreated2)->format('Y-m-d'));
				$hasFilter = true;
			}

			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$businesses = $businesses->orderBy(substr($sort, 1), 'desc');
				} else{
					$businesses = $businesses->orderBy($sort);
				}
			}
		}
		$filters = array(
			'columns' => ['name', 'city', 'zipcode', 'dateCreated_from', 'dateCreated_to'],
			'filters' => [
				['name' => 'name', 'text' => 'Name', 'type' => 'text', 'value' => $fname],
				['name' => 'city', 'text' => 'City', 'type' => 'text', 'value' => $fcity],
				['name' => 'zipcode', 'text' => 'Zipcode', 'type' => 'text', 'value' => $fzipcode],
				['name' => 'dateCreated', 'text' => 'Created Date', 'type' => 'date', 'value' => $fcreated1 . ',' . $fcreated2],
			],
			'scope' => 'franchise_businesslist',
		);
		$businesses = $businesses->paginate(20);
		$data = array(
			'businesses' => $businesses,
			'sort' => $sort,
			'filters' => $filters,
			'hasFilter' => $hasFilter,
			);

		return view('franchisor.business', $data);
	}

	public function businessSelectionList(Request $request){
		$businessSelections = BusinessSelection::where('isDeleted', 0)
				->whereNotNull('passed');
		
		$sort = '';
		if (MySession::get('prev_context', '') == $request->path()) {
			$sort = MySession::get('franchise_businessselectionlist_sort');
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$businessSelections = $businessSelections->orderBy(substr($sort, 1), 'desc');
				} else{
					$businessSelections = $businessSelections->orderBy($sort);
				}
			}
		}

		$businessSelections = $businessSelections->get();
		$data = array(
			'businessSelections' => $businessSelections,
			'sort' => $sort,
			);

		return view('franchisor.business_selection_list', $data);
	}

	public function showCreateBusiness(){
		$categories = AdminHelper::getCategories();
		$business = Business::where('createdBy', Auth::user()->id)
							->where('isDeleted', 2)
							->first();
		if ($business == NULL){
			$business = new Business;
			$business->createdBy = Auth::user()->id;
			$business->isDeleted = 2;
			$business->save();
		}
		// $franchisees = Franchisee::where('isActive', 1)->where('isDeleted', 0)->get();
		$user = Auth::user();
		if ($user->role == 2){
			$franchisees = Franchisee::where('isActive', 1)->where('isDeleted', 0)->get();
		} else{
			$franchisees = array(Franchisee::find($user->franchiseId));
		}
		$states = State::all();
		$data = array(
			'createOrEdit' => 'Add',
			'business' => $business,
			'categories' => $categories,
			'cats' => [],
			'cats2' => [],
			'fid' => Auth::user()->franchiseId,
			'subcats' => [],
			'subcats2' => [],
			'categoriesJson' => json_encode($categories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
			'franchisees' => $franchisees,
			'states' => $states,
			);

		return view('franchisor.business_crud', $data);
	}

	public function showEditBusiness($id){
		$categories = AdminHelper::getCategories();
		$business = BusinessV::find($id);
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}
		$franchisees = [];
		$franchise = $business->franchisees;
		$fid = '';
		if (count($franchise) > 0)
			$fid = $franchise[0]->id;
		$user = Auth::user();
		if ($user->role == 2){
			$franchisees = Franchisee::where('isActive', 1)->where('isDeleted', 0)->get();
		} else{
			$franchisees = array(Franchisee::find($user->franchiseId));
		}
		$states = State::all();
		$catslibbings = AdminHelper::getCatSiblings($business->businesssubcategoryId);
		$catslibbings2 = AdminHelper::getCatSiblings($business->businesssubcategoryId2);
		$data = array(
			'createOrEdit' => 'Edit',
			'business' => $business,
			'categories' => $categories,
			'cats' => $catslibbings['cats'],
			'cats2' => $catslibbings2['cats'],
			'subcats' => $catslibbings['subcats'],
			'subcats2' => $catslibbings2['subcats'],
			'categoriesJson' => json_encode($categories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
			'franchisees' => $franchisees,
			'fid' => $fid,
			'states' => $states,
			);

		return view('franchisor.business_crud', $data);
	}

	public function editContract(Request $request, $id = 0){
		if ($id == 0)
			return redirect('/franchise_businesses');
		$business = BusinessV::find($id);
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}
		$states = State::all();
		$categories = AdminHelper::getCategories();
		$bc = BusinessContract::where('businessId', $id)->where('isDeleted', 0)->first();
		$contractContent = Contract::find(1);
		$isNew = 0;
		if ($bc == NULL){
			$bc = new BusinessContract;
			$bc->contractId = AdminHelper::GUID();
			$bc->businessId = $id;
			$bc->isDeleted = 0;
			$bc->save();
		}
	
		$bc->name = $business->name;
		$bc->email = $business->email;
		$bc->website = $business->website;
		$bc->address = $business->address;
		$bc->city = $business->city;
		$bc->state = $business->state;
		$bc->zip = $business->zipcode;
		$bc->phone = $business->phone;
		$bc->subCatId = $business->businesssubcategoryId;
		$bc->subCatId2 = $business->businesssubcategoryId2;
        $bc->authorizedRep = $business->firstName . ' ' . $business->lastName;
		$bc->isDeleted = 0;
	
		$bc->effectiveDate = (new \DateTime($bc->effectiveDate))->format('m/d/Y');
		$bc->visibleOnWebsite = (new \DateTime($bc->visibleOnWebsite))->format('m/d/Y');
		$bc->paymentDueDate = (new \DateTime($bc->paymentDueDate))->format('m/d/Y');
		$bc->lastUpdated = (new \DateTime($bc->lastUpdated))->format('m/d/Y g:ia');
		
		if ($bc->businessMemberSignatureId == NULL || $bc->topTenRepSignatureId == NULL){
			$isNew = 1;
		}
		if ($request->input('renew') == 'true'){
			$isNew = 2;
		}
		$catsiblings = AdminHelper::getCatSiblings($business->businesssubcategoryId);
		$catsiblings2 = AdminHelper::getCatSiblings($business->businesssubcategoryId2);
		$data = array(
			'bc' => $bc,
			'business' => $business,
			'categories' => $categories,
			'cats' => $catsiblings['cats'],
			'cats2' => $catsiblings2['cats'],
			'subcats' => $catsiblings['subcats'],
			'subcats2' => $catsiblings2['subcats'],
			'categoriesJson' => json_encode($categories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE),
			'states' => $states,
			'contractContent' => $contractContent->content,
			'enterprise' => $contractContent->enterprise,
			'corporation' => $contractContent->corporation,
			'franchisee' => $business->franchisees()->first(),
			'isNew' => $isNew,
			);
		return view('franchisor.contract', $data);
	}

	public function businessComplaints($id=0){
		if ($id == 0){
			return redirect('/franchise_businesses');
		}
		$business = BusinessV::find($id);
		
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}

		$data = array(
			'business' => $business,
            'user' => Auth::user()
			);
		return view('franchisor.business_complaints', $data);
	}

	public function businessRatings($id=0){
		if ($id == 0){
			return redirect('/franchise_businesses');
		}
		$business = Business::find($id);
		
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}

		$ratings = $business->ratings()->where('isDeleted', 0);
		$sort = MySession::get('franchise_businessratings_sort', '');
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
		return view('franchisor.business_ratings', $data);
	}

	public function businessImages($id = 0){
		if ($id == 0){
			return redirect('/franchise_businesses');
		}
		$business = Business::find($id);
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}
		$data = array(
			'business' => $business
			);
		return view('franchisor.business_images', $data);
	}

	public function businessCoupons($id = 0){
		if ($id == 0){
			return redirect('/franchise_businesses');
		}
		$business = Business::find($id);
		if ($business == NULL){
			return redirect('/franchise_businesses');
		}
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
		return view('franchisor.business_coupons', $data);
	}

	public function createFromSelection($id){
		$bs = BusinessSelection::find($id);
		if ($bs->passed != 1){
			$result = array(
				'success' => 'false',
				'message' => "You can't add this business, because it doesn't meet TTP's requirements.",
				);
		} else{
			$contractName = $bs->BusinessContract;
			$names = explode(' ', $contractName);
			
			$fname = $names[0];
			$lname = '';
			if (count($names) > 1){
				$lname = $names[1];
			}
			$result = FranchiseHelper::saveBusiness($bs->franchiseId, 0, 0, $bs->businessName, '', '', '', $bs->businessZip, $bs->businessContact, $bs->businessContact2, '', '', $bs->businessPhone, '', NULL, 0, NULL, '', '', '', 0);
		}
		return json_encode($result);
	}
	
}

?>
