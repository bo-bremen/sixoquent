<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class AreaFields extends Model
{
    protected $table = 'sixcms_area_fields';
    
    public function area(){
        return $this->belongsTo('\Javogt\Sixoquent\Area');
    }
    
}
