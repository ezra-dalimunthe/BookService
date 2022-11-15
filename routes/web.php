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

$router->get('/api/v1/env-check', "AppCheckController@Inspection");
$router->get('/api/v1/log-check', "AppCheckController@testLog");


$router->group(["prefix" => "api/v1/genres"], function () use ($router) {
    $router->get("/", "GenreController@index");
});

$router->group(["prefix" => "api/v1/books","middleware"=>"auth"], function () use ($router) {
    $router->get("/", "BookController@index");
});

$router->group(["prefix" => "api/v1/book", "middleware"=>"auth"], function () use ($router) {
    $router->post("/", "BookController@store");
    $router->get("/{id}", "BookController@show");
    $router->put("/{id}", "BookController@update");
    $router->delete("/{id}", "BookController@destroy");
});

$router->group(["prefix" => "api/v1/entity"], function () use ($router) {
    $router->get("book/{id}", "EntityServiceController@showBook");
    $router->get("books", "EntityServiceController@showBooks");
});

$router->group(["prefix" => "api/v1/inter-service"], function () use ($router) {
    $router->put("book-inhand/{id}", "InterServiceController@bookInhand");

});
$router->group(["prefix" => "api/v1/statistic"], function () use ($router) {
    $router->get("books-on-hand", "StatisticController@booksOnHand");

});



Route::get('/dbcheck', function () {
    // Test database connection
    try {
        DB::connection()->getPdo();
        echo "database " . DB::connection()->getDatabaseName(), " is ready\n" ;
    } catch (\Exception $e) {
        die("Could not connect to the database. Please check your configuration. error:" . $e );
   }
});
