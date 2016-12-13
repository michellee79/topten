<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PUser extends Model
{
 
    protected $connection = 'mysql_phplist';
    protected $table = 'phplist_user_user';

    public $timestamps = false;
    
}
