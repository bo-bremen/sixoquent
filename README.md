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

// getting all articles of all areas
$post = Article::where('area_id', $posts_area->id)->where('lsid', $lsid);

?>
~~~
