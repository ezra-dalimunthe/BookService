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

Route::get('/api/docs', function () {
    $paths = [
        base_path() . '/app/Models',
        base_path() . '/app/Http/Controllers',
    ];
    $openapi = \OpenApi\Generator::scan($paths);
    return response()->json($openapi)->withHeaders([
        'Access-Control-Allow-Origin' => '*',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
    ]);;
});

$router->group(["prefix" => "api/v1/genres"], function () use ($router) {
    $router->get("/", "GenreController@index");
});

$router->group(["prefix" => "api/v1/books"], function () use ($router) {
    $router->get("/", "BookController@index");
});

$router->group(["prefix" => "api/v1/book"], function () use ($router) {
    $router->post("/", "BookController@store");
    $router->get("/{id}", "BookController@show");
    $router->put("/{id}", "BookController@update");
    $router->delete("/{id}", "BookController@destroy");
});
