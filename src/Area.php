<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'sixcms_area';
    
    const CREATED_AT = 'creation_date';
	const UPDATED_AT = 'change_date';
    
    public function folder(){
        return $this->belongsTo('\Sixoquent\Folder');
    }
    
    public function article(){
        return $this->hasMany('\Sixoquent\Article');
    }
    
    public function fields(){
        return $this->hasMany('\Sixoquent\AreaFields');
    }
    
    public function properties(){
        return $this->hasMany('\Sixoquent\AreaProperties');
    }

    public function hiddenProperty(){
        return $this->hasMany('\Sixoquent\AreaProperties')->where('label', 'hidden');
    }
    
}
