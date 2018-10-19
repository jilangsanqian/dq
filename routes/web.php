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