<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model
{
    protected $table = 'sixcms_article_data';
    protected $hidden = ['sindex'];
    public $timestamps = false;
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    }
}
