<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class AuthMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        // get token from request header
        $token = $request->header('Authorization'); 
        
        // Unauthorized response if token not there
        if(!$token) {
            return response()->json([
                'status' => 401,
                'error' => 'Token is required.'
            ], 401);
        }
      
        try {          
            $credentials = JWT::decode($token, env('APP_NAME'), ['HS256']);            
        } catch(ExpiredException $e) {          
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);          
        } catch(Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }

        $request->auth = $credentials->sub;        
        
        return $next($request);
    }
}