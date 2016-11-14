<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
	protected $table = 'sixcms_folder';
	
	public function parentFolder(){
		return $this->belongsTo('App\Folder', 'parent_id');
	}
	
	public function childrenFolder(){
		return $this->hasMany('App\Folder', 'parent_id');
	}
	
	public function areas(){
		return $this->hasMany('App\Area');
	}
	
}
