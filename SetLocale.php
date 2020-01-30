<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App;
use Config;

class SetLocale
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
        
       if (Session::has('locale')) { 
            $locale = Session::get('locale');
        } else { 
            $locale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if ($locale != 'jp' && $locale != 'en') {
                $locale = 'en';
            }
        }

        App::setLocale($locale);
        return $next($request);
    }
}
