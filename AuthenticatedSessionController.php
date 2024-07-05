<?php

// namespace App\Http\Controllers\Auth;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\Auth\LoginRequest;
// use App\Models\Admin;
// use Illuminate\Http\RedirectResponse;
// use Illuminate\Http\Request;
// use App\Models\Owner;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\View\View;

// class AuthenticatedSessionController extends Controller
// {
    /**
     * Display the login view.
     */
    // public function create(): View
    // {
    //     return view('auth.login');
    // }

    /**
     * Handle an incoming authentication request.
     */
//     public function store(LoginRequest $request)
//     {
//         $request->authenticate();
    
//         $request->session()->regenerate();
    
//         // Check if the user is authenticated as a web user, owner, or admin
//         if (Auth::guard('web')->check()) {
//             $user = Auth::guard('web')->user();
//             $request->session()->regenerate();
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Success you are logged in as user',
//                 'user' => $user
//             ]);
//         } elseif (Auth::guard('owner')->check()) {
//             // Check if the owner exists in the database and if the provided password matches the hashed password
//             $owner = Owner::where('email', $request->email)->first();
    
//             if ($owner && Hash::check($request->password, $owner->password)) {
//                 Auth::guard('owner')->login($owner);
//                 $user = Auth::guard('owner')->user();
//                 $request->session()->regenerate();
    
//                 return response()->json([
//                     'success' => true,
//                     'message' => 'Success you are logged in as owner',
//                     'user' => $user
//                 ]);
//             }
//         } elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
//             // Admin authentication passed
//             $admin = Auth::guard('admin')->user();
//             $request->session()->regenerate();
//             return response()->json([
//                 'success' => true,
//                 'message' => 'Success you are logged in as admin',
//                 'user' => $admin
//             ]);
//         }
    
//         // If no specific user type is detected, redirect to the home page
//         return back()->withErrors([
//             'email' => 'Invalid credentials.',
//         ])->withInput($request->only('email', 'remember'));
//     }

//     /**
//      * Destroy an authenticated session.
//      */
//     public function destroy(Request $request): RedirectResponse
//     {
//         Auth::guard('web')->logout();

//         $request->session()->invalidate();

//         $request->session()->regenerateToken();

//         return redirect('/');
//     }
// }


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     * 
     * 
     */
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $request->authenticate();
        
        // Check if the user is authenticated as a web user, owner, or admin
        if (Auth::guard('web')->check()) {
           // $user = Auth::guard('web')->user();
            $user = User::where('email', $request->email)->first();

            $token = $user->createToken($user->name.'-AuthToken')->plainTextToken;
            return response()->json([
                'success' => true,
                'message' => 'Success you are logged in as user',
                'user' => $user,
                'id' => $user->id,
                'token'=>$token,
                'userType' => 'user'
            ]);
        } elseif (Auth::guard('owner')->check()) {
            $owner = Owner::where('email', $request->email)->first();
        
            if ($owner && Hash::check($request->password, $owner->password)) {
                // Generate a new token for the owner
               
                $token = $owner->createToken($owner->name.'-AuthToken')->plainTextToken;
        
                return response()->json([
                    'success' => true,
                    'message' => 'Success you are logged in as owner',
                    'user' => $owner,
                    'id' => $owner->id,
                    'token'=>$token,
                    'userType' => 'owner' 
                ]);
            }
        } elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            // If authentication is successful, retrieve the authenticated admin user
            $admin = Auth::guard('admin')->user();
        
            // Generate a new personal access token for the admin
             $token = $admin->createToken($admin->name . '-AuthToken')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Success you are logged in as admin',
                'user' => $admin,
                'token' => $token, // Send the plain token to the client
                'userType' => 'Admin'
            ]);
        }
        
        // If authentication fails, return an error response
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.'
        ], 401);
    }

//     elseif (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
//         // If authentication is successful, retrieve the authenticated admin user
//         $admin = Auth::guard('admin')->user();
    
//         // Generate a new personal access token for the admin
//          $token = $admin->createToken($admin->name . '-AuthToken');

//         return response()->json([
//             'success' => true,
//             'message' => 'Success you are logged in as admin',
//             'user' => $admin,
//             'token' => $token, // Send the plain token to the client
//             'userType' => 'Admin'
//         ]);
//     }
    
//     // If authentication fails, return an error response
//     return response()->json([
//         'success' => false,
//         'message' => 'Invalid credentials.'
//     ], 401);
// }
//     }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        
        if ($user = $request->user()) {
            // Log out the user and invalidate their token(s)
            $user->tokens()->delete();
            return response()->json([
                'success' => true,
                'message' => 'Logged out successfully.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No user logged in.',
            ], 401); // Unauthorized status code
        }

    }
}
