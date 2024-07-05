<?php


namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\UploadedFile;



use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\Controller;


class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $photoUrl = $user->photo;
        $userImage = $photoUrl ? asset('storage/' . $photoUrl) : null;
        // return view('auth.user.profile', compact('user', 'userImage'));
        return response()->json([
            'user' => $user,
            'photoUrl' => $userImage,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('auth.user.edit', compact('user'));
    }

    // public function update(Request $request, $id)
    // {
    //     // First, check if the record exists in the database
    //     $user = User::find($id);

    //     // If the record doesn't exist, return an error response
    //     if (!$user) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     // Validate the request data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'status' => 'required|string|max:255',
    //         'phone' => 'required|string|max:255',
    //         'age' => 'required|integer|min:18|max:100',
    //         'gender' => 'required|in:Male,Female,Other',
    //         // Add validation rules for other fields as needed
    //     ]);

    //     // Update the user's information
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->status = $request->status;
    //     $user->phone = $request->phone;
    //     $user->age = $request->age;
    //     $user->gender = $request->gender;

    //     // If the password field is not empty, update the user's password
    //     if (!empty($request->password)) {
    //         $request->validate([
    //             'password' => 'required|string|min:8|confirmed',
    //         ]);

    //         $user->password = Hash::make($request->password);
    //     }

    //     // If a new photo has been uploaded, update the user's photo
    //     if ($request->hasFile('photo')) {
    //         $request->validate([
    //             'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //         ]);

    //         $photo = $request->file('photo');
    //         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
    //         $photoPath = $photo->storeAs('photos', $photoName, 'public');
    //         $user->photo = $photoPath;
    //     }

    //     // Save the updated user information
    //     $user->save();

    //     // Return a success response
    //     return response()->json(['message' => 'User updated successfully'], 200);
    // }


    // public function update(Request $request)
    // {
    //     // Get the authenticated user
    //     $user = User::find(Auth::id());
    
    //     // Validate the request data
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'status' => 'required|string|max:255',
    //         'phone' => 'required|string|max:255',
    //         'age' => 'required|integer|min:18|max:100',
    //         'gender' => 'required|in:Male,Female,Other',
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    //     ]);
    
    //     // Update the user's information
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->status = $request->status;
    //     $user->phone = $request->phone;
    //     $user->age = $request->age;
    //     $user->gender = $request->gender;
    
    //     // If the password field is not empty, update the user's password
    //     if (!empty($request->password)) {
    //         $user->password = Hash::make($request->password);
    //     }
    
    //     // If a new photo has been uploaded, update the user's photo
    //     if ($request->hasFile('photo')) {
    //         $photo = $request->file('photo');
    //         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
    //         $photoPath = $photo->storeAs('photos', $photoName, 'public');
    //         $user->photo = $photoPath;
    //     }
    
    //     // Save the updated user information
    //     $user->save();
    
    //     // Return a success response
    //     return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    // }
    

    // public function update(Request $request, $id)
    // {
    //     // Get the user
    //     $user = User::findOrFail($id);

    //     Log::info('Request data: ' . json_encode($request->all()));
    //     // Update the user's information
    //     $user->name = $request->name;
    //     $user->email = $request->email;
    //     $user->status = $request->status;
    //     $user->phone = $request->phone;
    //     $user->age = $request->age;
    //     $user->gender = $request->gender;
       

    
    //     // If the password field is not empty, update the user's password
    //     if (!empty($request->password)) {
    //         $user->password = Hash::make($request->password);
    //     }
    
    //     // If a new photo has been uploaded, update the user's photo
    //     if ($request->hasFile('photo')) {
    //         $photo = $request->file('photo');
    //         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
    //         $photoPath = $photo->storeAs('photos', $photoName, 'public');
    //         $user->photo = $photoPath;
    //     }
    
    //     // Save the updated user information
    //     $user->save();
    
    //     // Return a success response
    //     // return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    //     return response()->json(['success', 'Profile updated successfully.']);

    // }

//     public function update(Request $request, $id)
// {
//     // Validate the request data
//     $request->validate([
//         'name' => 'required|string|max:255',
//         'email' => 'required|email|max:255',
//         'password' => 'nullable|string|min:6',
//         'status' => 'nullable|string|max:255',
//         'gender' => 'nullable|string|in:male,female,other',
//         'age' => 'nullable|integer|min:18',
//         'phone' => 'nullable|string|max:20',
//         'photo' => 'nullable|image|max:2048',
//     ]);

//     // Find the user
//     $user = User::findOrFail($id);

//     // Update the user attributes based on request data
//     $user->name = $request->input('name');
//     $user->email = $request->input('email');
//     $user->status = $request->input('status', $user->status); // Use existing value if not provided
//     $user->gender = $request->input('gender', $user->gender); // Use existing value if not provided
//     $user->age = $request->input('age', $user->age); // Use existing value if not provided
//     $user->phone = $request->input('phone', $user->phone); // Use existing value if not provided

//     // Update password if provided
//     if ($request->filled('password')) {
//         $user->password = Hash::make($request->input('password'));
//     }

//     // Update photo if provided
//     if ($request->hasFile('photo')) {
//         $photo = $request->file('photo');
//         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//         $photoPath = $photo->storeAs('photos', $photoName, 'public');
//         $user->photo = $photoPath;
//     }

//     // Save the user
//     $user->save();

//     // Return a success response
//     return response()->json(['success' => 'Profile updated successfully.']);
// }

public function update(Request $request, $id)
{
    // dd($request->all());
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'nullable|string|min:8',
            'status' => 'required|string',
            'gender' => 'required|string',
            'age' => 'required|integer',
            'phone' => 'required|string|max:15',
            'photo' => 'nullable|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Step 4: Find the User
        $user = User::findOrFail($id);

        // Step 5: Update the User
        $userData = $request->except(['_token', '_method']); // exclude CSRF token and method spoofing field

        if ($request->has('password') && $request->password != null) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->has('photo')) {
            $photoBase64 = $request->input('photo');
            $photoData = base64_decode($photoBase64);
            $imageName = time(). '.'. 'jpg'; // or other extension
            $filePath = storage_path('public/images/'. $imageName);
            file_put_contents($filePath, $photoData);
            $userData['photo'] = $imageName;
        }

        // Debug the update query
        DB::enableQueryLog();

        $user->update($userData);

        $queries = DB::getQueryLog();

        // Log the update query
        Log::debug('Update query:', $queries);

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->validator->errors()->all();
        return response()->json(['message' => 'Error updating user', 'errors' => $errors], 422);
    }catch (\Exception $e) {
        Log::error('Error updating user: '. $e->getMessage());
        return response()->json(['message' => 'Error updating user'], 500);
    }
}
}
