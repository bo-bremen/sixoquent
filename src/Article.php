<?php

namespace Javogt\Sixoquent;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'sixcms_article';
    
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'change_date';
    
    public function area()
    {
        return $this->belongsTo('App\Area');
    }
    
    public function data(){
        return $this->hasMany('App\ArticleData');
    }
    
    private function addValue($key, $value){
        $this->$key = $value;
    }
    
    public function fulltext(){
        return $this->hasMany('App\ArticleFulltext');
    }
    
    public function article(){
        return $this->hasMany('App\ArticleArticle');
    }
    
    public function link(){
        return $this->hasMany('App\ArticleLink');
    }
    
    public function addDataAsFields($fieldnames = null){
        $query = $this->data();
        if(isset($fieldnames)){
            $query->whereIn('fieldname', $fieldnames);
        }
        $fields = $query->get(['fieldname', 'value']);
        foreach ($fields as $field) {
            $this->addValue($field->fieldname, $field->value);
        }
        return $this;
    }
    
    public function addLinkAsFields(){
        foreach ($this->link as $link) {
            $this->addValue($link->fieldname, $link->link_id);
        }
        unset($this->link);
        return $this;
    }
    
    public function addArticleAsFields($relationnames = null){
        $query = $this->article();
        if(isset($relationnames)){
            $query->whereIn('fieldname', $relationnames);
        }
        $relations = $query->get(['fieldname', 'rel_id']);
        foreach ($relations as $relation) {
            $this->addValue($relation->fieldname, $relation->rel_id);
        }
        return $this;
    }
	
    /**
    * returns attributes of an article
    *
    * @param  string  $id
    * @return Article the article attributes
    */
    public static function getArticleAttributes($id)
    {
        return Article::where('id', $id)
        ->with('article')
        ->first()
        ->addDataAsFields();
    }
}