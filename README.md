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
