<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleLink extends Model
{
    protected $table = 'sixcms_article_link';
    public $timestamps = false;
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    }
    
    public function linkArticle(){
        return $this->hasOne('\Sixoquent\Article', 'id', 'link_id');
    }

     public function rootArticle(){
        return $this->hasOne('\Sixoquent\Article', 'id', 'article_id');
    }
}