<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Owner;


use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class OwnerProfileController extends Controller
{
    public function show()
    {
        // $owner = Auth::guard('owner')->user();
       
        $owner = Auth::user();

        $photoUrl = $owner->photo;
        $ownerImage = $photoUrl ? asset('storage/' . $photoUrl) : null;
        // return view('auth.owner.profile', compact('owner','ownerImage'));
        return response()->json([
            'owner' => $owner,
            'photoUrl' => $ownerImage
        ]);
    }

    public function edit()
    {
        
        $owner =Auth::guard('owner')->user();
       // dd($owner);
         return view('auth.owner.edit', compact('owner'));
        //return response()->json(['success', 'Profile edit success.']);

        
    }

//     public function update(Request $request, $id)
// {
//     // Get the authenticated owner
//     $owner = Owner::findOrFail($id);
    
//     // Update owner's information
//     $owner->name = $request->name;
//     $owner->email = $request->email;
//     $owner->phone = $request->phone;
    
//     // Check if password is provided and update if necessary
//     if (!empty($request->password)) {
//         $owner->password = Hash::make($request->password);
//     }
    
//     // Check if a new photo has been uploaded and update if necessary
//     if ($request->hasFile('photo')) {
//         $photo = $request->file('photo');
//         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//         $photoPath = $photo->storeAs('photos', $photoName, 'public');
//         $owner->photo = $photoPath;
//     }
    
//     // Save the updated owner information
//     $owner->save();
    
//     // Redirect back with success message
//     return redirect()->route('owner.profile')->with('success', 'Profile updated successfully.');
// }

// public function update(Request $request)
// {
//     $id = Auth::guard('owner')->id();

//     $owner = Owner::findOrFail($id);
    
//     $owner->name = $request->name;
//     $owner->email = $request->email;
//     $owner->phone = $request->phone;
    
//     if (!empty($request->password)) {
//         $owner->password = Hash::make($request->password);
//     }
    
//     if ($request->hasFile('photo')) {
//         $photo = $request->file('photo');
//         $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//         $photoPath = $photo->storeAs('photos', $photoName, 'public');
//         $owner->photo = $photoPath;
//     }
    
//     $owner->save();
    
//     return redirect()->route('owner.profile')->with('success', 'Profile updated successfully.');
// }    

// public function update(Request $request, $id)
// {
//     try {
//         // Retrieve the authenticated owner
//         $owner = Owner::findOrFail($id);

//         // Validate the request data
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:owners,email,' . $id,
//             'phone' => 'required|string|max:255',
//             'password' => 'nullable|string|min:8|confirmed',
//             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         // Update owner's information
//         $owner->name = $request->name;
//         $owner->email = $request->email;
//         $owner->phone = $request->phone;

//         // Check if password is provided and update if necessary
//         if (!empty($request->password)) {
//             $owner->password = Hash::make($request->password);
//         }

//         // Check if a new photo has been uploaded and update if necessary
//         if ($request->hasFile('photo')) {
//             $photo = $request->file('photo');
//             $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//             $photoPath = $photo->storeAs('photos', $photoName, 'public');
//             $owner->photo =$photoPath;
//         }

//         // Save the updated owner information
//         $owner->save();

//         // Redirect back with success message
//         return redirect()->route('owner.profile')->with('success', 'Profile updated successfully.');
//     } catch (\Exception $e) {
//         // Log the error for debugging
//         logger()->error('Error updating owner profile: ' . $e->getMessage());

//         // Redirect back with error message
//         return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
//     }
// }

// public function update(Request $request, Owner $owner)
// {
//     try {
//         // Validate the request data
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:owners,email,' . $owner->id,
//             'phone' => 'required|string|max:255',
//             'password' => 'nullable|string|min:8|confirmed',
//             'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         ]);

//         // Update owner's information
//         $owner->name = $request->name;
//         $owner->email = $request->email;
//         $owner->phone = $request->phone;

//         // Check if password is provided and update if necessary
//         if (!empty($request->password)) {
//             $owner->password = Hash::make($request->password);
//         }

//         // Check if a new photo has been uploaded and update if necessary
//         if ($request->hasFile('photo')) {
//             $photo = $request->file('photo');
//             $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//             $photoPath = $photo->storeAs('photos', $photoName, 'public');
//             $owner->photo = $photoPath;
//         }

//         // Save the updated owner information
//         $owner->save();

//         // Redirect back with success message
//         return redirect()->route('owner.profile')->with('success', 'Profile updated successfully.');
//     } catch (\Exception $e) {
//         // Log the error for debugging
//         logger()->error('Error updating owner profile: ' . $e->getMessage());

//         // Redirect back with error message
//         return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
//     }
// }

// public function update(Request $request, $id)
// {
//     try {
//         // Add debug statement to see if the method is being called
//         logger()->info('Update method called.');

//         // $request->merge([
//         //     'name' => $request->input('name'),
//         //     'email' => $request->input('email'),
//         //     'phone' => $request->input('phone'),
//         //     'password' => $request->input('password'),
//         // ]);

//         // // Validate the request data
//         // $request->validate([
//         //     'name' => 'required|string|max:255',
//         //     'email' => 'required|string|email|max:255|unique:owners,email,' . $owner->id,
//         //     'phone' => 'required|string|max:255',
//         //     'password' => 'nullable|string|min:8|confirmed',
//         //     'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//         // ]);

//         $owner = Owner::findOrFail($id);
//         // Add debug statement to see the request data
//         logger()->info('Request data:', $request->all());

//         // Update owner's information
//         $owner->name = $request->name;
//         $owner->email = $request->email;
//         $owner->phone = $request->phone;

//         // Check if password is provided and update if necessary
//         if (!empty($request->password)) {
//             $owner->password = Hash::make($request->password);
//         }

//         // Check if a new photo has been uploaded and update if necessary
//         if ($request->hasFile('photo')) {
//             $photo = $request->file('photo');
//             $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//             $photoPath = $photo->storeAs('photos', $photoName, 'public');
//             $owner->photo = $photoPath;
//         }

//         // Save the updated owner information
//         $owner->save();

//         // Add debug statement to confirm the save operation
//         logger()->info('Owner profile updated.');

//         // Redirect back with success message
//        // return redirect()->route('owner.profile')->with('success', 'Profile updated successfully.');
//         return response()->json(['success', 'Profile updated successfully.']);
//     } 
//     // catch (\Illuminate\Validation\ValidationException $e) {
//     //     // Log the validation error for debugging
//     //     logger()->error('Validation error: ' . json_encode($e->errors()));
    
//     //     // Return detailed validation error message
//     //     return response()->json(['error' => $e->errors()], 422);
//     // } 
//     catch (\Exception $e) {

//         // Log the error for debugging
//         logger()->error('Error updating owner profile: ' . $e->getMessage());

//         // Redirect back with error message
//          return redirect()->back()->with('error', 'Failed to update profile. Please try again.');
//         //return response()->json(['error' => $e->getMessage()], 500);

//     }
// }

public function update(Request $request, $id)
{
    // dd($request->all());
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email',
            'password' => 'nullable|string|min:8',
            'phone' => 'required|string|max:15',
            'photo' => 'nullable|string|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Step 4: Find the User
        $owner = Owner::findOrFail($id);

        // Step 5: Update the User
        $ownerData = $request->except(['_token', '_method']); // exclude CSRF token and method spoofing field

        if ($request->has('password') && $request->password != null) {
            $ownerData['password'] = Hash::make($request->password);
        }

        if ($request->has('photo')) {
            $photoBase64 = $request->input('photo');
            $photoData = base64_decode($photoBase64);
            $imageName = time(). '.'. 'jpg'; // or other extension
            $filePath = storage_path('public/images/'. $imageName);
            file_put_contents($filePath, $photoData);
            $ownerData['photo'] = $imageName;
        }

        // Debug the update query
        DB::enableQueryLog();

        $owner->update($ownerData);

        $queries = DB::getQueryLog();

        // Log the update query
        Log::debug('Update query:', $queries);

        return response()->json(['message' => 'owner updated successfully', 'owner' => $owner], 200);
    } catch (\Illuminate\Validation\ValidationException $e) {
        $errors = $e->validator->errors()->all();
        return response()->json(['message' => 'Error updating owner', 'errors' => $errors], 422);
    }catch (\Exception $e) {
        Log::error('Error updating user: '. $e->getMessage());
        return response()->json(['message' => 'Error updating owner'], 500);
    }
}

// public function update(Request $request, Owner $owner)
// {
//     try {
//         // Add debug statement to see if the method is being called
//         logger()->info('Update method called.');

//         // Check if the request contains form data
//         if ($request->is('multipart')) {
//             // Retrieve the form data
//             $formData = $request->all();

//             // Handle form data
//             $name = $formData['name'] ?? null;
//             $email = $formData['email'] ?? null;
//             $password = $formData['password'] ?? null;
//             $phone = $formData['phone'] ?? null;
//             // Extract other fields as needed

//             // Extract the photo file from the form data
//             $photo = $request->file('photo');

//         } else {
//             // Handle JSON data
//             // Retrieve JSON data from the request
//             $jsonData = $request->json()->all();

//             // Extract data from JSON
//             $name = $jsonData['name'] ?? null;
//             $email = $jsonData['email'] ?? null;
//             // Extract other fields as needed

//             // No need to extract the photo file since it's handled differently for JSON data
//             $photo = $request->file('photo') ?? null;
//         }

//         // Update owner's information using the retrieved data
//         if ($name !== null) {
//             $owner->name = $name;
//         }
//         if ($email !== null) {
//             $owner->email = $email;
//         }
//         // Update other fields accordingly

//         // Check if a new photo has been uploaded and update if necessary
//         if ($photo !== null) {
//             // Process photo upload
//             $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
//             $photoPath = $photo->storeAs('photos', $photoName, 'public');
//             $owner->photo = $photoPath;
//         }

//         // Save the updated owner information
//         $owner->save();

//         // Add debug statement to confirm the save operation
//         logger()->info('Owner profile updated.');

//         // Return a success response
//         return response()->json(['success' => 'Profile updated successfully.']);
//     } catch (\Exception $e) {
//         // Log the error for debugging
//         logger()->error('Error updating owner profile: ' . $e->getMessage());

//         // Return an error response
//         return response()->json(['error' => 'Failed to update profile. Please try again.'], 500);
//     }
// }



}
