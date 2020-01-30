<?php

namespace App\Http\Middleware;
use Session;
use Closure;
use Route;

class RedirectIfAuthenticated
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
        $permissions = (array)Session::get('permission');
       
        $currentRouteName = explode('_', Route::currentRouteName())[0];
       
        
        // if(!in_array($currentRouteName, $permissions)){
        //     return redirect('/');
        // }
       
        return $next($request);
    }
}
