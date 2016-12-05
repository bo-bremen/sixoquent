<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleFulltext extends Model
{
    protected $table = 'sixcms_article_fulltext';
    public $timestamps = false;
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    }
}
