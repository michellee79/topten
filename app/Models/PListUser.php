<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PListUser extends Model
{
 
    protected $connection = 'mysql_phplist';
    protected $table = 'phplist_listuser';

    public $timestamps = false;
    
}
