<?php

namespace App\Http\Middleware;

use Session;
use Closure;
use Redirect;
use Illuminate\Support\Facades\Route;

class IsAuthenticated
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
        if(session()->has('token')){
            return $next($request);
        }
        return redirect('/login');
    }
}
