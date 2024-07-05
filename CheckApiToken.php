<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Gate;
class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $apiToken = $request->bearerToken();
    
        if (!Gate::allows('api-owner', $apiToken)) {
            return response()->json([
                'error' => 'Invalid API token'
            ], 401);
        }
    
        return $next($request);
    }
}
