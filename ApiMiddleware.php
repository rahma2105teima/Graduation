<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Owner;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
 
    //     if ($request->bearerToken() && Auth::guard('api')->check() && Auth::guard('api')->user()->role === 'owner') 
    //     {
    //         return $next($request);
    //     }


    public function handle(Request $request, Closure $next):Response
    {
        if ($request->bearerToken() && Auth::guard('api')->check() && Auth::guard('api')->user()->getAuthIdentifierName() === 'id' && Auth::guard('api')->user()->id === Auth::guard('api')->user()->owner->id) {
            return $next($request);
        }

        // if ($request->bearerToken() && Auth::guard('api')->check() && Owner::hasRole(Auth::guard('api')->user()->role)) 
        // {
        //     return $next($request);
        // }

        // if ($request->bearerToken() && Auth::guard('api')->check() && Auth::guard('api')->user()->hasRole(Owner::ROLE_OWNER)) {
        //     return $next($request);
        // }

        Log::error("Bearer Token: " . $request->bearerToken());
        Log::error("API Guard Check: " . Auth::guard('api')->check());
        if (Auth::guard('api')->check()) {
            Log::error("User Role: " . Auth::guard('api')->user()->role);
        }
    
    
        return response()->json([
            'error' => 'Unauthenticated ors Unauthorized'
        ], 401);
    
        }
    }

