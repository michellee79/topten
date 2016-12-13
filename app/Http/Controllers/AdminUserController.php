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

use App\Jobs\ImportUser;
use App\Jobs\SendReminderEmail;

class AdminUserController extends Controller{

	public function __construct(){
		$this->user = Auth::user();
		$this->location = MySession::getZipcode();
	}

	public function promo(){
		$promos = Promo::where('isDeleted', 0);
		$franchisees = Franchisee::where('isDeleted', 0)
								->where('code', '<>', 'Top Ten Percent')
								->orderBy('name')
								->get();
		$f = MySession::get('admin_promo_franchise', '');
		if ($f != ''){
			$promos = $promos->where('code', 'like', $f .'%');
		}
		$sort = MySession::get('franchise_promo_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$promos = $promos->orderBy(substr($sort, 1), 'desc');
			} else{
				$promos = $promos->orderBy($sort);
			}
		}
		$totalSignedUp = $promos->sum('totalSignedUp');
		$totalActivated = $promos->sum('totalActivated');
		$promos = $promos->get();
		//$totalSignedUp = User::where('isDeleted', 0)->count('id');
		//$totalActivated = User::where('isDeleted', 0)->where('isActivated', 1)->count('id');
		$data = array(
			'promos' => $promos,
			'franchisees' => $franchisees,
			'sel' => $f,
			'totalSignedUp' => $totalSignedUp,
			'totalActivated' => $totalActivated,
			'sort' => $sort,
			);
		return view('admin.promo', $data);
	}

	public function manageActiveUsers(){
		$fkey = MySession::get('admin_activeuser_filter_key', '');
		$fval = '';
		$users = User::where('isDeleted', 0)
					->where('isActivated', 1);
		if ($fkey != ''){
			$fval = MySession::get('admin_activeuser_filter_value', '');
			$users = $users->where($fkey, 'like', '%' . $fval . '%');
		}
		$sort = MySession::get('admin_activeusers_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$users = $users->orderBy(substr($sort, 1), 'desc');
			} else{
				$users = $users->orderBy($sort);
			}
		}
		$users = $users->paginate(40);
		$data = array(
			'users' => $users,
			'fkey' => $fkey,
			'fval' => $fval,
			'sort' => $sort,
			);
		return view('admin.manage_active_users', $data);
	}

	public function manageInactiveUsers(){
		$fkey = MySession::get('admin_inactiveuser_filter_key', '');
		$fval = '';
		$users = User::where('isDeleted', 0)
					->where('isActivated', 0);
		if ($fkey != ''){
			$fval = MySession::get('admin_inactiveuser_filter_value', '');
			$users = $users->where($fkey, 'like', '%' . $fval . '%');
		}

		$cnt = $users->count();
		$sort = MySession::get('admin_inactiveusers_sort');
		if ($sort != NULL && $sort != ''){
			if (substr($sort, 0, 1) == '-'){
				$users = $users->orderBy(substr($sort, 1), 'desc');
			} else{
				$users = $users->orderBy($sort);
			}
		}
		$users = $users->paginate(20);
		$data = array(
			'users' => $users,
			'count' => $cnt,
			'sort' => $sort,
			'fkey' => $fkey,
			'fval' => $fval,
			);
		return view('admin.manage_inactive_users', $data);
	}

	public function exportExcelInactiveUsers(){
		Excel::create('inactive_users', function($excel){
			$excel->sheet('Inactive Users', function($sheet){
				$sheet->row(1, array('FirstName', 'LastName', 'Email', 'Zipcode', 'Promo Code'));
				$sheet->cell('A1:E1', function($cells){
					$cells->setAlignment('center');
					$cells->setFontWeight('bold');
				});
				$row = 2;
				$users = User::where('isDeleted', 0)
					->where('isActivated', 0)
					->get();
				foreach ($users as $user) {
					$sheet->row($row, array($user->firstName, $user->lastName, $user->email, $user->zipcode, $user->promoCode));
					$row++;
				}
			});
		})->download('xlsx');
	}

	public function importUsers(){
		return view('admin.import_users');
	}

	public function signupUsers($pid){
		$users = User::where('promoId', $pid)->where('isDeleted', 0);
		$sort = MySession::get('franchise_signedusers_sort');
        $sortable = ['promoCode', 'firstName', 'lastName', 'email', 'createdDate', 'isActivated'];
		if (in_array($sort, $sortable)) {
			if (substr($sort, 0, 1) == '-'){
				$users = $users->orderBy(substr($sort, 1), 'desc');
			} else{
				$users = $users->orderBy($sort);
			}
		}
		$users = $users->paginate(20);
		$data = array(
			'users' => $users,
			'sort' => $sort,
			);
		return view('admin.signed_users', $data);
	}

	public function setPromoFilter($code=''){
		MySession::set('admin_promo_franchise', $code);
	}

	public function setActiveUserFilter(Request $request){
		$key = $request->input('key');
		MySession::set('admin_activeuser_filter_key', $key);
		if ($key != ''){
			$value = $request->input('value');
			MySession::set('admin_activeuser_filter_value', $value);
		}
	}

	public function setInactiveUserFilter(Request $request){
		$key = $request->input('key');
		MySession::set('admin_inactiveuser_filter_key', $key);
		if ($key != ''){
			$value = $request->input('value');
			MySession::set('admin_inactiveuser_filter_value', $value);
		}
	}

	public function getUserDetail($id){
		$user = User::find($id);
		$result = array();
		if ($user == NULL){
			$result['message'] = 'No such user';
			$result['success'] = 'false';
		} else{
			$result['message'] = 'Got user detail';
			$result['success'] = 'true';
			$result['promoCode'] = $user->promoCode;
			$result['email'] = $user->email;
			$result['firstName'] = $user->firstName;
			$result['lastName'] = $user->lastName;
			$result['zipcode'] = $user->zipcode;
		}
		return json_encode($result);
	}

	public function saveUserDetail(Request $request, $id){
		$firstName = $request->input('firstName');
		$lastName = $request->input('lastName');
		$zipcode = $request->input('zipcode');
		$result = AdminHelper::updateUser($id, $firstName, $lastName, $zipcode);
		return json_encode($result);
	}

	public function deleteUser($id){
		$result = AdminHelper::deleteUser($id);
		return json_encode($result);
	}

	public function importUsersFromCSV(Request $request){
        $result = array();

        $promoCode = $request->input('promo');

        $promo = Promo::where('code', $promoCode)->first();
        if ($promo == NULL){
        	$result['success'] = 'false';
        	$result['message'] = 'No such promo code';
        } else {
        
    		$valid_exts = array('csv'); // valid extensions
            
            $path = public_path() . '/tmp/'; // upload directory
            $fileName = NULL;
            $file = \Input::file('file');
            // get uploaded file extension
            //$ext = $file['extension'];
            $ext = substr($file->getClientOriginalName(), -3, 3);
    
            if ($ext == 'csv' || $ext == 'CSV'){
	            $name = $file->getClientOriginalName();
    
    	        $location = $path . $name;
    	        $file->move($path,$name);

    	        $file = fopen($location, 'r');
		        $headers = fgetcsv($file);
		        $headerNames = ['FirstName', 'LastName', 'Email', 'Zipcode'];
		        $success = true;
		        foreach ($headers as $header){
		        	if (array_search($header, $headerNames) === FALSE){
		        		$success = false;
		        		break;
		        	}
		        }
    
    	        // $this->dispatch(new SendReminderEmail());
    	        if ($success){
    	        	$this->dispatch(new ImportUser($promoCode, $location));
    	        	$result['success'] = 'true';
	    	        $result['message'] = "Finished importing!";
	            	$result['path'] = $location;
    	        } else{
    	        	$result['success'] = 'false';
            		$result['message'] = 'Missing headers. FirstName, LastName, Email, Zipcode should be there.' . $ext;
    	        }
    
            } else{
            	$result['success'] = 'false';
            	$result['message'] = 'Wrong file type. Please upload CSV format.' . $ext;
            }
        }
        return json_encode($result);
	}

}

?>