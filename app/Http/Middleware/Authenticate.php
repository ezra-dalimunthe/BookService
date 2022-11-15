<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Http;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

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

        $baseUrl = env("AUTH_SERVICE_URL");
        $token = $request->bearerToken();
        $response = Http::acceptJson()->post(
            $baseUrl . "/api/v1/auth/check", [
                "token" => $token,
                "app_id" => "0330430430434",
            ]);
        if ($response->status() == 200) {
            $userdata = $response->object();
            $user = new \App\Models\User;
            $user->display_name = $userdata->display_name;
            $user->id = $userdata->id;
            $user->status_id = $userdata->status_id;
            $user->email = $userdata->email;
            $user->roles = $userdata->roles;
            $this->auth->guard()->setUser($user);
            return $next($request);
        }
        return response('Unauthorized.', 401);
    }
}
