<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Model\User;
use App\Model\Business;
use App\Model\BusinessV;
use App\Model\Promo;
use App\Model\Franchisee;

use Auth;

use App\Helper\AdminHelper;
use App\MySession;

class FranchisorPromoController extends Controller{
	private $user;
	private $location;

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function promo(Request $request){
		$franchisee = $this->user->franchisee;
		if ($this->user->role == 2){
			$franchisee = Franchisee::where('code', 'Top Ten Percent')->first();
		}
		$promos = Promo::where('isDeleted', 0)->where('code', 'like', $franchisee->code . '%');

		$hasFilter = $fcode = $fassign = $fcreated1 = $fcreated2 = $sort = '';

		if (MySession::get('prev_context', '') == $request->path()) {
			$fcode = MySession::get('franchise_promolist_filter_code', '');
			$fassign = MySession::get('franchise_promolist_filter_assignedTo', '');
			$fcreated1 = MySession::get('franchise_promolist_filter_created_from', '');
			$fcreated2 = MySession::get('franchise_promolist_filter_created_to', '');

			$promos = $promos->where('code', 'like', $fcode . '%')
									->where('assignedTo', 'like', '%' . $fassign . '%');

			if ($fcode != '' || $fassign != ''){
				$hasFilter = true;
			}

			if ($fcreated1 != ''){
				$promos = $promos->where('created', '>=', \DateTime::createFromFormat('m/d/Y', $fcreated1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($fcreated2 != ''){
				$promos = $promos->where('created', '<=', \DateTime::createFromFormat('m/d/Y', $fcreated2)->format('Y-m-d'));
				$hasFilter = true;
			}

			$sort = MySession::get('franchise_promo_sort');
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$promos = $promos->orderBy(substr($sort, 1), 'desc');
				} else{
					$promos = $promos->orderBy($sort);
				}
			}
		}

		$totalSignedUp = $promos->sum('totalSignedUp');
		$totalActivated = $promos->sum('totalActivated');
		$promos = $promos->get();
		// $totalSignedUp = User::where('promoCode', 'like', $franchisee->code . '%')->where('isDeleted', 0)->count('id');
		// $totalActivated = User::where('promoCode', 'like', $franchisee->code . '%')->where('isDeleted', 0)->where('isActivated', 1)->count('id');
		
		$filters = array(
			'columns' => ['code', 'assignedTo', 'created_from', 'created_to'],
			'filters' => [
				['name' => 'code', 'text' => 'Code', 'type' => 'text', 'value' => $fcode],
				['name' => 'assignedTo', 'text' => 'Assigned To', 'type' => 'text', 'value' => $fassign],
				['name' => 'created', 'text' => 'Created Date', 'type' => 'date', 'value' => $fcreated1 . ',' . $fcreated2],
			],
			'scope' => 'franchise_promolist',
			'hasFilter' => $hasFilter,
		);

		$data = array(
			'promos' => $promos,
			'sort' => $sort,
			'totalSignedUp' => $totalSignedUp,
			'totalActivated' => $totalActivated,
			'filters' => $filters,
			'hasFilter' => $hasFilter,
			);
		return view('franchisor.promo', $data);
	}

	public function signupUsers(Request $request, $pid=''){
		$franchisee = $this->user->franchisee;
        if($franchisee == NULL) {
            return redirect('/login');
        }
		$users = User::where('isDeleted', 0);
		if ($pid != ''){
			$users = $users->where('promoId', $pid);
		}

		$hasFilter = $ffirst = $flast = $femail = $fcreated1 = $fcreated2 = $sort = '';

		if (MySession::get('prev_context', '') == $request->path()) {
			$ffirst = MySession::get('franchise_signedupusers_filter_firstName', '');
			$flast = MySession::get('franchise_signedupusers_filter_lastName', '');
			$femail = MySession::get('franchise_signedupusers_filter_email', '');
			$fcreated1 = MySession::get('franchise_signedupusers_filter_createdDate_from', '');
			$fcreated2 = MySession::get('franchise_signedupusers_filter_createdDate_to', '');

			$users = $users->where('firstName', 'like', '%' . $ffirst . '%')
									->where('lastName', 'like', '%' . $flast . '%')
									->where('email', 'like', '%' . $femail . '%');

			if ($ffirst != '' || $flast != '' || $femail != ''){
				$hasFilter = true;
			}

			if ($fcreated1 != ''){
				$users = $users->where('createdDate', '>=', \DateTime::createFromFormat('m/d/Y', $fcreated1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($fcreated2 != ''){
				$users = $users->where('createdDate', '<=', \DateTime::createFromFormat('m/d/Y', $fcreated2)->format('Y-m-d'));
				$hasFilter = true;
			}

			$sort = MySession::get('franchise_signedusers_sort');
            $sortable = ['promoCode', 'firstName', 'lastName', 'email', 'createdDate', 'isActivated'];
			if (in_array($sort, $sortable)){
				if (substr($sort, 0, 1) == '-'){
					$users = $users->orderBy(substr($sort, 1), 'desc');
				} else{
					$users = $users->orderBy($sort);
				}
			}
		}
		$users = $users->paginate(20);
		
		$filters = array(
			'columns' => ['firstName', 'lastName', 'email', 'createdDate_from', 'createdDate_to'],
			'filters' => [
				['name' => 'firstName', 'text' => 'First Name', 'type' => 'text', 'value' => $ffirst],
				['name' => 'lastName', 'text' => 'Last Name', 'type' => 'text', 'value' => $flast],
				['name' => 'email', 'text' => 'Email', 'type' => 'text', 'value' => $femail],
				['name' => 'createdDate', 'text' => 'Signed Up Date', 'type' => 'date', 'value' => $fcreated1 . ',' . $fcreated2],
			],
			'scope' => 'franchise_signedupusers'
		);

		$data = array(
			'users' => $users,
			'sort' => $sort,
			'filters' => $filters,
			'hasFilter' => $hasFilter,
			);
		return view('franchisor.signed_users', $data);
	}

	public function activeUsers(Request $request, $pid){
		$users = User::where('promoId', $pid)->where('isActivated', 1)->where('isDeleted', 0);

		$hasFilter = $ffirst = $flast = $femail = $fcreated1 = $fcreated2 = $factivate1 = $factivate2 = $sort = '';

		if (MySession::get('prev_context', '') == $request->path()) {
			$ffirst = MySession::get('franchise_activeusers_filter_firstName', '');
			$flast = MySession::get('franchise_activeusers_filter_lastName', '');
			$femail = MySession::get('franchise_activeusers_filter_email', '');
			$fcreated1 = MySession::get('franchise_activeusers_filter_createdDate_from', '');
			$fcreated2 = MySession::get('franchise_activeusers_filter_createdDate_to', '');
			$factivate1 = MySession::get('franchise_activeusers_filter_activationDate_from', '');
			$factivate2 = MySession::get('franchise_activeusers_filter_activationDate_to', '');

			$users = $users->where('firstName', 'like', '%' . $ffirst . '%')
									->where('lastName', 'like', '%' . $flast . '%')
									->where('email', 'like', '%' . $femail . '%');

			if ($ffirst != '' || $flast != '' || $femail != ''){
				$hasFilter = true;
			}

			if ($fcreated1 != ''){
				$users = $users->where('createdDate', '>=', \DateTime::createFromFormat('m/d/Y', $fcreated1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($fcreated2 != ''){
				$users = $users->where('createdDate', '<=', \DateTime::createFromFormat('m/d/Y', $fcreated2)->format('Y-m-d'));
				$hasFilter = true;
			}

			if ($factivate1 != ''){
				$users = $users->where('activationDate', '>=', \DateTime::createFromFormat('m/d/Y', $factivate1)->format('Y-m-d'));
				$hasFilter = true;
			}
			
			if ($factivate2 != ''){
				$users = $users->where('activationDate', '<=', \DateTime::createFromFormat('m/d/Y', $factivate2)->format('Y-m-d'));
				$hasFilter = true;
			}

			$sort = MySession::get('franchise_activeusers_sort');
			if ($sort != NULL && $sort != ''){
				if (substr($sort, 0, 1) == '-'){
					$users = $users->orderBy(substr($sort, 1), 'desc');
				} else{
					$users = $users->orderBy($sort);
				}
			}
		}
		
		$users = $users->paginate(20);

		$filters = array(
			'columns' => ['firstName', 'lastName', 'email', 'createdDate_from', 'createdDate_to', 'activationDate_from', 'activationDate_to'],
			'filters' => [
				['name' => 'firstName', 'text' => 'First Name', 'type' => 'text', 'value' => $ffirst],
				['name' => 'lastName', 'text' => 'Last Name', 'type' => 'text', 'value' => $flast],
				['name' => 'email', 'text' => 'Email', 'type' => 'text', 'value' => $femail],
				['name' => 'createdDate', 'text' => 'Signed Up Date', 'type' => 'date', 'value' => $fcreated1 . ',' . $fcreated2],
				['name' => 'activationDate', 'text' => 'Activation Date', 'type' => 'date', 'value' => $factivate1 . ',' . $factivate1],
			],
			'scope' => 'franchise_activeusers',
			'hasFilter' => $hasFilter,
		);

		$data = array(
			'users' => $users,
			'sort' => $sort,
			'filters' => $filters,
			'hasFilter' => $hasFilter,
			);
		return view('franchisor.active_users', $data);
	}

	public function users(Request $request){

	}
	
}

?>