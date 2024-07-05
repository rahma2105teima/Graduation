<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeactivatedAccountController extends Controller
{
    

    public function show(User $user)
    {
        return view('deactivated_accounts.show', compact('user'));
    }

    public function deleteAccount($id)
    {
        try {
            // Ensure user is authenticated as admin
            $admin = Auth::user();
            if (!$admin) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }

            // Retrieve the account to be deleted
            $user = User::find($id);

            // Check if the user exists
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            // Delete the user account
            $user->delete();

            // Return a success response
            return response()->json(['message' => 'User account deleted successfully'], 200);

        } catch (\Exception $e) {
            \Log::error('Failed to delete user account: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to delete user account'], 500);
        }
   }

}