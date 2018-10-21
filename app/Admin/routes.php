<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->get('/novel', 'NovelController@index');
	$router->get('/book', 'BookController@index');
    $router->get('/cat', 'CatController@index');
	$router->post('/book/spliderStart', 'BookController@spliderStart');
    $router->post('/novel/spliderStart', 'NovelController@spliderStart');
	$router->post('/book/spliderStart', 'BookController@spliderStart');
    $router->post('/cat/spliderStart', 'CatController@spliderStart');



	$router->put('/book/{id}','BookController@updateInfo')->where(['id' => '[0-9]+']);
	$router->get('/book/{id}/edit','BookController@details')->where(['id' => '[0-9]+']);
});
