<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class CheckTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $token = JWTAuth::parseToken()->check(); 

            if (!$token) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'Invalid token'
                ], 401);
            }
        } catch (TokenInvalidException $e) {
            // Token is invalid
            return response()->json([
                'status' => 'Error',
                'message' => 'Invalid token'
            ], 401);
        }

        return $next($request);
    }
}
