<?php

// namespace App\Http\Middleware;

// use Closure;

// class CorsMiddleware
// {
//     protected $allowedOrigins = [
//         'http://localhost:5173',
//         'http://localhost:3000', // Add this line to allow requests from another frontend port
//     ];

//     public function handle($request, Closure $next)
//     {
//         // $response = $next($request);

//         // $origin = $request->header('Origin');

//         // if (in_array($origin, $this->allowedOrigins)) {
//         //     $response->header('Access-Control-Allow-Origin', $origin);
//         //     $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//         //     $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//         // }

//         $response = $next($request);

//         foreach ($this->allowedOrigins as $origin) {
//             $response->headers->set('Access-Control-Allow-Origin', $origin);
//         }
        
//         $response = $next($request);
//         $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
//         $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//         $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-CSRF-TOKEN');
//         $response->headers->set('Access-Control-Allow-Credentials', 'true');

//         return $response;
//     }
// }



// namespace App\Http\Middleware;

// use Closure;

// class CorsMiddleware
// {
//     protected $allowedOrigins = [
//         'http://localhost:5173',
//         'http://localhost:3000', // Add this line to allow requests from another frontend port
//     ];

//     public function handle($request, Closure $next)
//     {
//         $response = $next($request);

//         // Check if the request origin is in our allowed origins list
//         if ($request->headers->has('Origin') && in_array($request->headers->get('Origin'), $this->allowedOrigins)) {
//             // Set the CORS headers to allow all methods, headers, and credentials
//             $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));
//             $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
//             $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-CSRF-TOKEN');
//             $response->headers->set('Access-Control-Allow-Credentials', 'true');
//         }

//         return $response;
//     }
// }




namespace App\Http\Middleware;

use Closure;

class CorsMiddleware
{
    // public function handle($request, Closure $next)
    // {
    //     $response = $next($request);

    //     // Check if the request origin is in our allowed origins list
    //     if ($request->headers->has('Origin') && in_array($request->headers->get('Origin'), config('cors.allowed_origins', []))) {
    //         // Set the CORS headers to allow all methods, headers, and credentials
    //         $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));
    //         $response->headers->set('Access-Control-Allow-Methods', implode(',', config('cors.allowed_methods', [])));
    //         $response->headers->set('Access-Control-Allow-Headers', implode(',', config('cors.allowed_headers', [])));
    //         $response->headers->set('Access-Control-Allow-Credentials', config('cors.supports_credentials', false) ? 'true' : 'false');
    //     }

    //     return $response;
    // }
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization , Accept');

        return $response;
    }
}
