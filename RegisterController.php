<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Owner; // Import the Owner model
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $userData = $request->only(['name', 'email', 'password', 'status', 'gender', 'age', 'city', 'where_to_go', 'phone', 'photo' ,'phonenumber']);

      //  dd($userData);

      if ($request->hasFile('photo')) {
        // Retrieve the uploaded image
        $image = $request->file('photo');

        // Generate a unique name for the image
        $imageName = time() . '_' . $image->getClientOriginalName();

        // Move the image to the storage directory
        $image->storeAs('public/images', $imageName);

        // Add the image path to the user data
        $userData['photo'] = 'images/' . $imageName;
    }
    
        $userType = $request->input('user_type');
    
        $email = $request->input('email');
        $adminDomains = ['example.com', 'adminexample.com']; // Add your admin email domains here
        $domain = explode('@', $email)[1];
    
        if (in_array($domain, $adminDomains)) {
            // If the user's email domain matches an admin domain, create an admin record
            Admin::create($userData);
    
            Session::flash('message', 'Registration successful! You are now an admin.');
            session(['user_type' => 'admin']);
        }  elseif ($userType === 'owner') {
            $owner = Owner::create($userData);
            //  Auth::login($owner);

            $apiToken = Str::random(80); // Generate a random token
            $owner->api_token = hash('sha256', $apiToken); // Hash the token before storing
            $owner->save();
            Auth::guard('owner')->login($owner ,true);

            Session::flash('message', 'Registration successful! You are now an owner.');
            session(['user_type' => 'owner']);

            Auth::guard('owner')->setUser($owner);
        } else {
            $user =  User::create($userData);
            Auth::login($user);

    
            Session::flash('message', 'Registration successful! You are now a user.');
            session(['user_type' => 'user']);
        }
    
        return redirect()->route('register.message');
    }
    

    public function showRegistrationMessage()
    {
        $message = Session::get('message');
        return view('auth.message', compact('message'));
    }
}
