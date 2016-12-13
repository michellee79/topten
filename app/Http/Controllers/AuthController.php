<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Model\User;
use Auth;

use App\MySession;
use App\Helper\FrontHelper;

use Illuminate\Http\Request;

class AuthController extends Controller{
	
	public function login(Request $request){
		$email = $request->input('name');
		$password = $request->input('password');
		$result = array();
		$u = User::where(function($query) use ($email){
			$query->where('loginName', 'like', $email)->orWhere('email', 'like', $email);
		})->where('isDeleted', 0)->first(); 
		if ($u != NULL){
			if ($u->loginName == NULL){
				$u->loginName = $email;
			}
			if (Auth::attempt(array('email' => $u->loginName, 'password' => $password))){
				$user = Auth::user();
				if (!$user->isActivated){
					$result['success'] = 'false';
					$result['message'] = 'This user is not activated';
				} else{
					if (MySession::getZipcode() == NULL || MySession::getZipcode() == ''){
						$result['geo_resolved'] = MySession::setZipcode($user->zipcode);
					}
					$result['success'] = 'true';
					$result['message'] = 'Successfully logged in.';
				}
			} else{
				$result['success'] = 'false';
				$result['message'] = 'Wrong password';
			}
		} else{
			$result['success'] = 'false';
			$result['message'] = 'No such user';
		}
		
		return json_encode($result);
	}

	public function logout(){
		Auth::user()->timestamps = false;
		Auth::logout();
	}

	public function setLocationNonmember(Request $request){
		$result = array();
		$location = $request->input('location');
		try{
			MySession::setZipcode($location);
			$result['success'] = 'true';
			$result['message'] = "You've successfully logged in as a guest with temporary location.";
		} catch(\Exception $e){
			$result['success'] = 'false';
			$result['message'] = 'Error occured. ' . $e->getMessage();
		}
		return json_encode($result);
	}

	public function changePassword(Request $request){
		$result = array();
		if (Auth::guest()){
			$result['success'] = 'false';
			$result['message'] = "Please login";
		} else{
			$user = Auth::user();

			if (FrontHelper::changePassword($user, $request->input('oldPass'), $request->input('newPass'))){
				$result['success'] = 'true';
				$result['render'] = view('components.change_password_finish')->render();
				$result['renderMobile'] = view('components.change_password_finish_mobile')->render();
			} else{
				$result['success'] = 'false';
				$result['message'] = "Password incorrect.";
			}
		}
		return json_encode($result);
	}

	
	public function verifyUsername(Request $request){
		$email = $request->input('email');
		$result = array();
		$user = User::where('email', 'like', $email)->first();
		if ($user == NULL){
			$result['success'] = 'false';
			$result['message'] = 'No such user';
		} else{
			$result['success'] = 'true';
			$result['message'] = 'Valid User';
			$result['question'] = $user->question;
		}
		return json_encode($result);
	}

	public function verifyAnswer(Request $request){
		$email = $request->input('email');
		$answer = $request->input('answer');
		$question = $request->input('question');
		$result = array();
		$r = FrontHelper::resetUserPassword($email, $question, $answer);
		if ($r == false){
			$result['success'] = 'false';
			$result['message'] = 'No such user';
		} else{
			$result['success'] = 'true';
			$result['message'] = 'Password has been reset';
		}
		return json_encode($result);
	}
}

?>