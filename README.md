# sixoquent
Model classes to connect sixcms with eloquent/laravel

## installation

~~~shell
composer require bo-bremen/sixoquent
~~~

~~~shell
php composer.phar require bo-bremen/sixoquent
~~~

## examples

~~~php
<?php

use Sixoquent\Article;

// getting all articles of all areas
$articles = Article::all();

?>
~~~

~~~php
<?php

use Sixoquent\Area;

// getting all articles of area with id 1
$articles = Area::find(1)->article;

// same as
$articles = Area::where('id', 1)->first()->article;

// same as
$area = Area::where('id', 1)->first();
$articles = \Sixoquent\Article::where('area_id', $area->id)->get();

// [...]

?>
~~~

~~~php
<?php

use Sixoquent\Area;
use Sixoquent\Article;

$lsid = 'yoshi';

// getting area by title
$posts_area = Area::where('title', 'posts')->first();

// getting article from specific area and with specific lsid
$post = Article::where('area_id', $posts_area->id)->where('lsid', $lsid)->first();

?>
~~~

~~~php
<?php

use Sixoquent\Article;

$post = Article::find(5);

// Adding all additional fields
$post = $post->addDataAsFields();

?>
~~~

~~~php
<?php

use Sixoquent\Article;

$post = Article::where('id', 5)->get(['id','title'])->first();

// Adding only specific fields
$post = $post->addDataAsFields(['content']);

?>
~~~

~~~php
<?php

use Sixoquent\Article;

$posts = Article::where('area_id', 1)->get(['id','title']);

// Adding additional data to multiple items
foreach($posts as &$post){
    $post = $post->addDataAsFields();
}

?>
~~~

~~~php
<?php

use Sixoquent\Article;

$link_fieldname = 'image_link';

$post = Article::find(1);

// Getting linked data
$linked_article = 
    $post // There is the root post
    ->link() // getting all links
    ->where('fieldname', 'image_link') // getting only this one
    ->first() // getting the model of the link
    ->linkArticle() // getting the linked article of the link
    ->first(); // getting the model of the article

?>
~~~
