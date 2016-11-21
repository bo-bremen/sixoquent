<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleArticle extends Model
{
    protected $table = 'sixcms_article_article';
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    } 

    public function relArticle(){
        return $this->hasOne('\Sixoquent\Article', 'id', 'rel_id');
    }
}
