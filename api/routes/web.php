<?php

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

$router->get('/key', function () {
    return \Illuminate\Support\Str::random(32);
});

$router->group(['namespace' => '\Rap2hpoutre\LaravelLogViewer'], function () use ($router) {
    $router->get('logs', ['uses' => 'LogViewerController@index', 'name' => 'logs']);
});

$router->group(['prefix' => 'api', 'middleware' => ['auth', 'watchman']], function () use ($router) {
    $router->get('/', ['uses' => '\Src\Heimdall\Controllers\IndexController@index', 'name' => 'api.index']);
});

$router->group(['prefix' => 'register', 'middleware' => ['watchman']], function () use ($router) {
    $router->get('/', ['uses' => '\Src\Heimdall\Controllers\SignupController@index', 'name' => 'signup.index']);
    $router->post('/signup', ['uses' => '\Src\Heimdall\Controllers\SignupController@signup', 'name' => 'signup.register']);
});
