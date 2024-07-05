<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Owner; // Import the Owner model
use Symfony\Component\HttpFoundation\Response;

class AuthOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if(auth()->guard('owner')->check()){
    //         return $next($request);
    //     }
    
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Unauthenticated',
    //     ], Response::HTTP_UNAUTHORIZED);
    // }

    public function handle(Request $request, Closure $next)
    {
    //     $user = $request->user();

    //     // Check if the user is authenticated and if they are an owner
    //     if ($user && $this->isOwner($user)) {
    //         return $next($request);
    //     }

    //     return response()->json(['error' => 'you are not allowed'], 403);
    // }

    // // Check if the authenticated user is an owner
    // private function isOwner($user)
    // {
    //     // Check if the user exists in the owners table
    //     return Owner::where('email', $user->email)->exists();
    // }

    if (!Auth::check()) {
        // If not logged in as an owner, return a JSON response with an error message
        return response()->json(['error' => 'Unauthorized. You must be logged in as an owner.'], 403);
    }

    // Check if the logged-in user's email exists in the Owner table
    if (Owner::where('email', Auth::user()->email)->exists()) {
        // If the email exists in the Owner table, proceed with the request
        return $next($request);
    }

    // If the email doesn't exist in the Owner table, return a JSON response with an error message
    return response()->json(['error' => 'Unauthorized. You are not an owner and cannot upload accommodation.'], 403);
}
}
