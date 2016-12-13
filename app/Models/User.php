<?php

namespace App\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstName', 'lastName', 'email', 'loginName'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function ratings(){
        return $this->hasMany('App\Model\Rating', 'userId');
    }

    public function complaints(){
        return $this->hasMany('App\Model\Complaint', 'userId');
    }

    public function coupons(){
        return $this->belongsToMany('App\Model\Coupon', 'usercoupons', 'userId', 'couponId');
    }

    public function franchisee(){
        return $this->belongsTo('App\Model\Franchisee', 'franchiseId');
    }
}
