<?php

namespace Sixoquent;

use Illuminate\Database\Eloquent\Model;
use Sixoquent\ArticleLink;
use Sixoquent\ArticleArticle;
use Sixoquent\ArticleData;
use Carbon\Carbon;

class Article extends Model
{
    protected $table = 'sixcms_article';
    
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'change_date';
    
    public function area()
    {
        return $this->belongsTo('\Sixoquent\Area');
    }
    
    public function data()
    {
        return $this->hasMany('\Sixoquent\ArticleData');
    }
    
    public function mediaData()
    {
        return $this->hasMany('\Sixoquent\MediaData');
    }
    
    public function fulltext()
    {
        return $this->hasMany('\Sixoquent\ArticleFulltext');
    }
    
    public function article()
    {
        return $this->hasMany('\Sixoquent\ArticleArticle');
    }
    
    public function link()
    {
        return $this->hasMany('\Sixoquent\ArticleLink');
    }
    

    /**
    * Checks if article is online. Needs properties published, online_date, offline_date to be loaded.
    * @return Boolean
    */
    public function online(){
        $this->online = false; 
        if($this->published == true){
            $online_date = new Carbon($this->online_date);
            $offline_date = new Carbon($this->offline_date);
            $this->online = $online_date->isPast() && $offline_date->isFuture();
        };
        return $this->online;
    }
    
    /**
    * Saves key value pair as ArticleData of this Article
    * @param {String} $fieldname
    * @param {String} $value
    */
    public function saveData($fieldname, $value)
    {
        $articleData = \Sixoquent\ArticleData::where('article_id', $this->id)->where('fieldname', $fieldname)->first();
        if (!isset($articleData)) {
            $articleData = new \Sixoquent\ArticleData;
        }
        
        $articleData->article_id = $this->id;
        $articleData->area_id = $this->area_id;
        $articleData->fieldname = $fieldname;
        $articleData->value = $value;
        $articleData->sindex = substr($value, 0, 19);
        
        $articleData->save();
    }
    
    public function saveMultipleData($data){
        foreach($data as $key => $value){
            $this->saveData($key, $value);
        }
    }
    
    /**
    * Deletes ArticleData of this Article
    */
    public function deleteData(){
        $articleData = \Sixoquent\ArticleData::where('article_id', $this->id)->delete();
    }
    
    public function getValue($fieldname){
        $value = \Sixoquent\ArticleData::where('article_id', $this->id)->where('fieldname', $fieldname)->first();
        return $value->attributes['value'];
    }

    public function checkFieldname($fieldname){
        return \Sixoquent\ArticleData::where('article_id', $this->id)->where('fieldname', $fieldname)->exists();
    }

    public function checkForSpecificRelation(\Illuminate\Database\Eloquent\Model $article){
        return \Sixoquent\ArticleArticle::where('article_id', $this->id)->where('rel_id', $article->id)->exists();
    }
    
    public function checkForRelations(){
        return \Sixoquent\ArticleArticle::where('article_id', $this->id)->exists();
    }
    
    public function deleteAllRelations(){
        \Sixoquent\ArticleArticle::where('article_id', $this->id)->delete();
        \Sixoquent\ArticleArticle::where('rel_id', $this->id)->delete();
    }
    
    public function deleteRelation(\Illuminate\Database\Eloquent\Model $article){
        \Sixoquent\ArticleArticle::where('article_id', $this->id)->where('rel_id', $article->id)->delete();
        \Sixoquent\ArticleArticle::where('article_id', $article->id)->where('rel_id', $this->id)->delete();
    }
    
    /**
    * Adds ArticleData models as properties to Article model. Fieldname of ArticleData becomes property name, value becomes value.
    * @param {Array} [$fieldnames] Uses only ArticleData with given fieldnames
    * @return {\Sixoquent\Article}
    */
    public function addDataAsFields($fieldnames = null)
    {
        $query = $this->data();
        if (isset($fieldnames)) {
            $query->whereIn('fieldname', $fieldnames);
        }
        $fields = $query->get(['fieldname', 'value']);
        foreach ($fields as $field) {
            $this->addValue($field->fieldname, $field->value);
        }
        return $this;
    }
    
    private function addValue($key, $value)
    {
        $this->$key = $value;
    }
    
    public function addLinkAsFields($linknames = null)
    {
        $query = $this->link();
        if (isset($linknames)) {
            $query->whereIn('fieldname', $linknames);
        }
        $links = $query->get(['fieldname', 'link_id']);
        foreach ($links as $link) {
            $this->addValue($link->fieldname, $link->link_id);
        }
        return $this;
    }
    
    public function addArticleAsFields($relationnames = null)
    {
        $query = $this->article();
        if (isset($relationnames)) {
            $query->whereIn('fieldname', $relationnames);
        }
        $relations = $query->get(['fieldname', 'rel_id']);
        foreach ($relations as $relation) {
            $this->addValue($relation->fieldname, $relation->rel_id);
        }
        return $this;
    }
    
    public function parentLink()
    {
        return $this->belongsTo('\Sixoquent\ArticleLink', 'id', 'article_id')
        ->where('fieldname', 'sixcms_parent')
        ->select(['article_id','link_id']);
    }
    
    public function childrenLinks()
    {
        return $this->hasMany('\Sixoquent\ArticleLink', 'link_id', 'id')
        ->where('fieldname', 'sixcms_parent')
        ->select(['article_id','link_id']);
    }
    
    public function addChildren($fields = null, $additionalData = null)
    {
        $childrenLinks = $this->childrenLinks()->get();
        if (!$childrenLinks->isEmpty()) {
            $this->children = collect();
            foreach ($childrenLinks as $childLink) {
                $link_article = $this->convertChildLinkToChildArticle($childLink, $fields, $additionalData);
                $this->children->push($link_article);
            }
        }
    }
    
    private function convertChildLinkToChildArticle($childLink, $fields, $additionalData)
    {
        $link_article_query = $childLink->rootArticle();
        
        if (isset($fields)) {
            $link_article_query->select($fields);
        }
        
        $link_article = $link_article_query->first();
        
        if (isset($additionalData)) {
            $link_article->addDataAsFields($additionalData);
        }
        
        $link_article->addChildren($fields, $additionalData);
        
        return $link_article;
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