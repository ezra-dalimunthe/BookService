<?php

namespace App\Http\Middleware;

use Closure;

class CorsWithOptions extends \Fruitcake\Cors\HandleCors
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {

        $response = parent::handle($request, $next, $guard);
        if ($request->getMethod() === 'OPTIONS') {
            /**
             * return only method allowed for this endpoint
             */

            $path = $request->path();
            $routes = \Route::getRoutes();
            $err = null;
            $filtered = ["OPTIONS"];
            try {
                $filtered = array_filter($routes, function ($r) use ($path) {

                    $uri = $r["uri"];

                    if ($path == $uri) {
                        return true;
                    }

                    if (\Illuminate\Support\Str::startsWith($uri, "/")) {
                        $uri = substr($uri, 1);
                    }
                    if (\Illuminate\Support\Str::startsWith($path, "/")) {
                        $path = substr($path, 1);
                    }
                    $pattern1 = '/\{[a-zA-Z0-9_\-:]+\}/';
                    $pattern2 = '/\//';
                    $uri = "/" . preg_replace([$pattern1, $pattern2], ['[a-zA-Z0-9_\-]+', '\/'], $uri) . "/";

                    $exist = preg_match($uri, $path, $matches);
                    return (bool) sizeof($matches);
                });
            } catch (\Throwable $th) {
                $err = $th->getMessage();
            }

            $origin = $request->headers->get("origin") ?? "*";
            $methods = array_column($filtered, "method");
            $methods[] = "OPTIONS";

            /**
             * uncoment codes below to allow request with method that not allowed;
             */
            //$requestMethod = $request->headers->get("Access-Control-Request-Method");
            // if ($requestMethod) {
            //    $methods[] = $requestMethod;
            // }

            $methods = implode(", ", array_unique($methods));
            return response($err, 200)
                ->header("Access-Control-Allow-Origin", $origin)
                ->header("Access-Control-Allow-Methods", $methods)
                ->header("Access-Control-Allow-Headers", "*")
                ->header("Allow", $methods)
            ;
        }

        return $response;
    }
}
