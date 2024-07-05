<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\User;
use App\Models\Owner;
use App\Models\Accommodation;


class AdminController extends Controller
{

    public function getAllUsers()
    {
        // $admin = Auth::user();
        // if ($admin) {
        //     try {
                $users = User::all();
                return response()->json(['users' => $users], 200);
            // } catch (\Exception $e) {
            //     return response()->json(['message' => 'Failed to retrieve users'], 500);
            // }
        // } else {
            // return response()->json(['message' => 'Unauthorized to view users'], 403);
        // }
    }

    public function registerdelete($id)
    {
        // Authenticate using the 'admin' guard
        // $admin = Auth::guard('admin')->user();
        // $admin = Auth::user();
        
        // // Ensure the authenticated user is an admin
        // if ($admin) {
        //     try {
                // Find the user by ID
                $user = User::findOrFail($id);

                // Delete the user
                $user->delete();

                // Return a JSON response indicating success
        //         return response()->json(['message' => 'User data deleted successfully'], 200);
        //     } catch (\Exception $e) {
        //         // Handle any exceptions (e.g., user not found)
        //         return response()->json(['message' => 'Failed to delete user'], 500);
        //     }
        // } else {
        //     // Return a JSON response indicating unauthorized access
        //     return response()->json(['message' => 'Unauthorized to delete users'], 403);
        // }
    }

   
    public function index()
    {
        // $admin = Auth::user();
        // if ($admin) {
        //     try {
        $owners = Owner::all();
        return response()->json($owners, 200);
            // }
            // catch (\Exception $e) {
            //     return response()->json(['message' => 'Failed to show owners'], 500);
            // }  }
          }
    public function destroy($id)
    {
        // $admin = Auth::user();

        // if ($admin) {
        // try {
            $owner = Owner::findOrFail($id);
            $owner->delete();
            return response()->json(['message' => 'Owner deleted successfully'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Failed to delete owner'], 500);
        // } } 
     }    
}
