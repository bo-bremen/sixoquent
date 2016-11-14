<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleFulltext extends Model
{
    protected $table = 'sixcms_article_fulltext';
    
    public function article(){
        return $this->belongsTo('\Javogt\Sixoquent\Article');
    }
}
