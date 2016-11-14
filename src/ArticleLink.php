<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleLink extends Model
{
    protected $table = 'sixcms_article_link';
    
    public function article(){
        return $this->belongsTo('\App\Article');
    }
}
