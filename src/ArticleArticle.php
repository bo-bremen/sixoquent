<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleArticle extends Model
{
    protected $table = 'sixcms_article_article';
    
    public function article(){
        return $this->belongsTo('\Javogt\Sixoquent\Article');
    } 
}
