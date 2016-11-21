<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class MediaData extends Model
{
    protected $table = 'sixcms_media_data';
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    }
    
}
