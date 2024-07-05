<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // public function logout()
    // {
    //     Auth::logout();

    //     return redirect()->route('login');
    // }
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         // Authentication passed...
    //         Session::flash('message', 'login successful! You are now in home');
    //     }

    //     return redirect()->back()->withInput()->withErrors(['email' => 'Invalid email or password']);
    // }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Attempt to log in as a user
        if (Auth::attempt($credentials)) {
           Session::flash('message', 'login successful! You are now in home as user');
          return redirect()->route('login.message');
        //    return redirect()->intended('/');
       // return view('auth.failed');
        }
//to check here through postman comment session and route and the throw validation
       


           if (Auth::guard('owner')->attempt($credentials)) {
            $owner = Auth::guard('owner')->user();

            return response()->json([
                'token_type' => 'Bearer',
                'expires_in' => 31536000,
                'access_token' => $owner->api_token,
            ]);
            //  Session::flash('message', 'Login successful! You are now in home in an owner.');
            //  return redirect()->route('register.message');
          }
        // Attempt to log in as an admin
        if (Auth::guard('admin')->attempt($credentials)) {
           Session::flash('message', 'login successful! You are now in admin dashboard');
           return redirect()->route('register.message');
            // return redirect()->intended('/');
           // return view('auth.failed');
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
        // Authentication failed
        // return redirect()->route('login')->withErrors(['email' => 'Invalid email or password']);
    }

    
    public function showloginMessage()
{
    $message = Session::get('message');
    return view('auth.message', compact('message'));
}
}
