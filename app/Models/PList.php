<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PList extends Model
{
    protected $connection = 'mysql_phplist';
    protected $table = 'phplist_list';

    public $timestamps = false;
    
    public function users(){
    	return $this->belongsToMany('App\Model\PUser', 'phplist_listuser', 'listid', 'userid');
    }
}
