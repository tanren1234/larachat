<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Headers', 'Authorization ,x-requested-with , Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json ,application/x-www-form-urlencoded');
        $response->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS ');
        $response->header('Access-Control-Allow-Credentials', 'false');

        if($request->method() == 'OPTIONS'){

            return response('allow', 200)
                ->header('Access-Control-Allow-Headers', 'Authorization ,x-requested-with , Origin, Content-Type, Cookie, Accept, multipart/form-data, application/json ,application/x-www-form-urlencoded')
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Credentials', 'false')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PATCH, PUT, OPTIONS');
        }
        return $response;
    }
}
