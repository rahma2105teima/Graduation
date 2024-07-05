<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *This method checks the incoming HTTP request and performs any necessary logic to determine if
     * the request should proceed. Typically, this might involve checking if the user is an admin.
     * If the request is allowed, it passes the request to the next middleware/handler in the stack.
     * 
     * @param  \Illuminate\Http\Request  $request The incoming HTTP request.
     * @param  \Closure  $next The next middleware/handler in the request pipeline.
     * @return mixed The response from the next middleware/handler or an appropriate response for blocked requests.
     */
    public function handle(Request $request, Closure $next)
    {
        // Middleware logic here

        return $next($request);
    }
}
