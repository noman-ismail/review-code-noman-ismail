<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $uri = explode('/',$_SERVER['REQUEST_URI']);
        if (! $request->expectsJson()) {
            if(in_array(admin,$uri)){
                return route("admin");
            }
            if(in_array('login',$uri)){
                return route("login");
            }

            return route('login');
        }
    }
}