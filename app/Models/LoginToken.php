<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class LoginToken extends Model
{
    public $timestamps = false;
    protected $table = 'logintokens';
}
