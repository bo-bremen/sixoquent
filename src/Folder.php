<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
	protected $table = 'sixcms_folder';
	
	public function parentFolder(){
		return $this->belongsTo('Sixoquent\Folder', 'parent_id');
	}
	
	public function childrenFolder(){
		return $this->hasMany('Sixoquent\Folder', 'parent_id');
	}
	
	public function areas(){
		return $this->hasMany('Sixoquent\Area');
	}
	
}
