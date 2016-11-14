<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class ArticleData extends Model
{
    protected $table = 'sixcms_article_data';
    protected $hidden = ['sindex'];
    
    public function article(){
        return $this->belongsTo('\App\Article');
    }
}
