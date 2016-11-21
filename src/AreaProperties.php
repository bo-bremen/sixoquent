<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class AreaProperties extends Model
{
    protected $table = 'sixcms_area_properties';
    
    public function area(){
        return $this->belongsTo('\Sixoquent\Area');
    }
}
