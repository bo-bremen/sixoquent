<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'sixcms_area';
    
    const CREATED_AT = 'creation_date';
	const UPDATED_AT = 'change_date';
    
    public function folder(){
        return $this->belongsTo('\Javogt\Sixoquent\Folder');
    }
    
    public function article(){
        return $this->hasMany('\Javogt\Sixoquent\Article');
    }
    
    public function fields(){
        return $this->hasMany('\Javogt\Sixoquent\AreaFields');
    }
    
    public function properties(){
        return $this->hasMany('\Javogt\Sixoquent\AreaProperties');
    }

    public function hiddenProperty(){
        return $this->hasMany('\Javogt\Sixoquent\AreaProperties')->where('label', 'hidden');
    }
    
}
