<?php

namespace App\Http\Middleware;
use \Firebase\JWT\JWT;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\Route;
use \App\Services\HelperService;


class AuthenticateWithRoutes
{
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;
    protected $jwtDecoded;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
        $this->helperServiceObject = new helperService();
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
        
        if ($this->helperServiceObject->checkIfTokenExists($request->header('token'))){
            $responseArray = $this->helperServiceObject->constructResponseArray(401, "failure", 'Unauthorized', "Unauthorized", $content = []);
            return response()->json($responseArray, 401);
        }
        
        $this->jwtDecoded = $this->helperServiceObject->tokenDecryption($request->header('token'));
        
        if(!$this->helperServiceObject->payloadArrayStructureCheck($this->jwtDecoded)){
            $responseArray = $this->helperServiceObject->constructResponseArray(400, "failure", 'Insufficient Data', "Insufficient Data", $content = []);
            return response()->json($responseArray);
        }

        if(!$this->helperServiceObject->permissionsCheck(explode('_', $request->route()[1]['as'])[0], $this->jwtDecoded)){
            $responseArray = $this->helperServiceObject->constructResponseArray(401, "failure", 'Unauthorized', "Unauthorized", $content = []);
            return response()->json($responseArray, 401);
        }

        return $next($request);

    }


}
