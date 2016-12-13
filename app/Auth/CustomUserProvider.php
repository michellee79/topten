<?php

namespace App\Auth;

use App\Model\User;
use Carbon\Carbon;
use Illuminate\Auth\GenericUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;

class CustomUserProvider implements UserProvider{

	/**
	 * Retrieve a user by their unique identifier.
	 *
	 * @param  mixed $identifier
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */

	public function retrieveById($identifier){
		$qry = User::where('id', '=', $identifier);
		if ($qry->count() > 0){
			$user = $qry->select('id', 'firstName', 'lastName', 'city', 'state', 'zipcode', 'email', 'loginName', 'dob'
				, 'mobilePhone', 'password', 'question', 'answer', 'passwordSalt', 'promoCode', 'createdDate', 'isActivated', 'activationDate'
				, 'isDeleted', 'firstTimeLogin', 'role', 'franchiseId', 'remember_token')->first();
			return $user;
		}
		return NULL;
	}


	/**
	 * Retrieve a user by by their unique identifier and "remember me" token.
	 *
	 * @param  mixed $identifier
	 * @param  string $token
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */

	public function retrieveByToken($identifier, $token){
		$qry = User::where('id', '=', $identifier)
			->where('remember_token', '=', $token);
		if ($qry->count() > 0){
			$user = $qry->select('id', 'firstName', 'lastName', 'city', 'state', 'zipcode', 'email', 'loginName', 'dob'
				, 'mobilePhone', 'password', 'question', 'answer', 'passwordSalt', 'promoCode', 'createdDate', 'isActivated', 'activationDate'
				, 'isDeleted', 'firstTimeLogin', 'role', 'franchiseId', 'remember_token')->first();
			return $user;
		}
		return NULL;
	}


	/**
	 * Update the "remember me" token for the given user in storage.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable $user
	 * @param  string $token
	 * @return void
	 */

	public function updateRememberToken(Authenticatable $user, $token){
		$user->setRememberToken($token);
		$user->save();
	}


	/**
	 * Retrieve a user by the given credentials.
	 *
	 * @param  array $credentials
	 * @return \Illuminate\Contracts\Auth\Authenticatable|null
	 */

	public function retrieveByCredentials(array $credentials){
		//$qry = User::where('loginName', 'like', $credentials['email'])->where('isDeleted', 0)->where('isActivated', 1);
		// global $name;
		$name = $credentials['email'];
		// $qry = User::where(function($query){
		// 	global $name;
		// 	$query->where('email', 'like', $name)
		// 		->orWhere('email', 'like', $name)
		// 		;
		// });
		$qry = User::where('loginName', 'like', $name)->where('isDeleted', 0);

		if ($qry->count() > 0){
			$user = $qry->select('id', 'firstName', 'lastName', 'city', 'state', 'zipcode', 'email','loginName',  'dob',  'mobilePhone', 'password',
			 	'question', 'answer', 'passwordSalt', 'promoCode', 'createdDate', 'isActivated', 'activationDate' , 'isDeleted',
			 	'firstTimeLogin', 'role', 'franchiseId', 'remember_token')->first();
			return $user;
		}
		return NULL;
	}


	/**
	 * Validate a user against the given credentials.
	 *
	 * @param  \Illuminate\Contracts\Auth\Authenticatable $user
	 * @param  array $credentials
	 * @return bool
	 */

	public function validateCredentials(Authenticatable $user, array $credentials){
		$salt = base64_decode($user->passwordSalt);
		$password = $credentials['password'];
		$utf16Password = mb_convert_encoding($password, 'UTF-16LE', 'UTF-8');
		$calculatedPassword = base64_encode(sha1($salt . $utf16Password, true));
		if (strtolower($user->loginName) == strtolower($credentials['email']) && $user->getAuthPassword() == $calculatedPassword){
			return true;
		}
		return false;
	}
}

?>