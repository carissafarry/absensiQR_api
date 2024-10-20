<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'users'], function () use ($router) {
    $router->post('/getAll', 'UserController@getAll');
    $router->post('/getUser/{id}', 'UserController@getUser');
    $router->post('/create', 'UserController@create');
    $router->post('/update', 'UserController@update');
    $router->post('/delete', 'UserController@delete');
});

$router->group(['prefix' => 'absensi'], function () use ($router) {
    $router->post('/getAll', 'AbsensiController@getAll');
    $router->post('/getAbsensi', 'AbsensiController@getAbsensi');
    $router->post('/create', 'AbsensiController@create');
    $router->post('/update', 'AbsensiController@update');
    $router->post('/delete', 'AbsensiController@delete');
});
