<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'sixcms_area';
    
    const CREATED_AT = 'creation_date';
	const UPDATED_AT = 'change_date';
    
    public function folder(){
        return $this->belongsTo('App\Folder');
    }
    
    public function article(){
        return $this->hasMany('App\Article');
    }
    
    public function fields(){
        return $this->hasMany('App\AreaFields');
    }
    
    public function properties(){
        return $this->hasMany('App\AreaProperties');
    }

    public function hiddenProperty(){
        return $this->hasMany('App\AreaProperties')->where('label', 'hidden');
    }
    
}
