<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;
use Mpociot\HasCompositeKey\HasCompositeKey;

class ArticleData extends Model
{
    use HasCompositeKey;
    
    protected $table = 'sixcms_article_data';
    protected $hidden = ['sindex'];
    public $timestamps = false;
    protected $fillable = ['article_id', 'value'];
    protected $primaryKey = ['article_id', 'fieldname'];
    
    public function article(){
        return $this->belongsTo('\Sixoquent\Article');
    }
    
}