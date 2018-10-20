<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', function () {
//    return view('welcome');
//分类
//return view('cat');
//内容
//return view('content');
//单本书籍介绍
//return view('book');
//});
Route::get('/','Book\IndexController@index');
Route::get('/wapsort/{cat}_{page}.html','Book\IndexController@category')
    ->where(['cat' => '[0-9]+','page' => '[0-9]+']);

Route::get('/oversort/{page}.html','Book\IndexController@overBook')
    ->where(['page' => '[0-9]+']);

Route::get('/book/desc/{bookid}.html','Book\IndexController@bookDesc')
    ->where(['bookid' => '[0-9]+']);


Route::get('/book/{bookid}/{chapterid}.html','Book\IndexController@content')
    ->where(['bookid' => '[0-9]+','chapterid' => '[0-9]+']);

Route::get('/book/list/{bookid}/{page}.html','Book\IndexController@listAsc')
    ->where(['bookid' => '[0-9]+','page' => '[0-9]+']);

Route::get('/book/list/{bookid}/{desc}/{page}.html','Book\IndexController@list')
    ->where(['bookid' => '[0-9]+','page' => '[0-9]+','desc' => 'desc']);

Route::post('/search','Book\IndexController@search');
