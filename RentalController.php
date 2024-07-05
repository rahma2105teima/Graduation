<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;
use App\Models\Accommodation;
use App\Models\Rental;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class rentalController extends Controller
{

    public function index($accommodation_id)
    {
        $accommodation = Accommodation::find($accommodation_id);
        if (!$accommodation) {
            return redirect()->route('error.page', ['message' => 'Accommodation not found']);
        }
    
        return view('auth.rentalForm', compact('accommodation', 'accommodation_id'));
    }

    public function rentalForm($accommodation_id)
{
    $accommodation = Accommodation::find($accommodation_id);
    if (!$accommodation) {
        return redirect()->route('error.page', ['message' => 'Accommodation not found']);
    }

    return view('rental.form', compact('accommodation'));
}
    public function store_rental(Request $request)
    {
        $user_id = Auth::id();
        $data = request()->all();
        $image = request('img')->store('receipts', 'public');
        $refrence_number = request('reference_number');
        $end_date = request('end_date');
        //$start_date = created_at()->addDays(5)->format('Y-m-d');
        $start_date = now()->addDays(5)->format('Y-m-d');
        $accommodation_id = $request->input('accommodation_id');
        // $accommodation_id = $data['accommodation_id'];
        //$user_id = Auth::id(); // Get the ID of the currently authenticated user
        //$accommodation_id=Accommodation::where('id',$accommodation_id)->first()->id;
        $rental = Rental::create([
            'start_date'=>$start_date,
            'end_date' => $end_date,
            'reference_number' => $refrence_number,
            'user_id' => $user_id,
            'accommodations_id' => $accommodation_id,
            'receipt' => $image,
            'confirmed'=>0,
        ]);
        // return to_route(route:'accommodation.showAll');
        return response()->json(['rental' => $rental], 201);
    }

//     public function store_rental(Request $request)
// {
//     // Retrieve the authenticated user's ID
//     $user_id = Auth::id();

//     // Retrieve the request data
//     $reference_number = $request->input('reference_number');
//     $end_date = $request->input('end_date');
//     $start_date = now()->addDays(5)->format('Y-m-d');
//     $accommodations_id = $request->input('accommodation_id'); // Rename to accommodations_id

//     // Retrieve the uploaded image file
//     $receipt = $request->file('img'); // Rename to receipt

//     // Check if an image was uploaded
//     if ($receipt) { // Change variable name to receipt
//         // Generate a unique name for the image
//         $imageName = time() . '_' . $receipt->getClientOriginalName(); // Change variable name to receipt

//         // Store the image in the storage directory
//         $receiptPath = $receipt->storeAs('public/receipts', $imageName); // Change variable name to receiptPath

//         // Create the rental record with the image path
//         Rental::create([
//             'start_date' => $start_date,
//             'end_date' => $end_date,
//             'reference_number' => $reference_number,
//             'user_id' => $user_id,
//             'accommodations_id' => $accommodations_id, // Rename to accommodations_id
//             'receipt' => $receiptPath, // Change variable name to receiptPath
//             'confirmed' => 0,
//         ]);

//         // Return a response indicating success
//         return response()->json(['message' => 'Rental created successfully'], 201);
//     } else {
//         // If no image was uploaded, return an error response
//         return response()->json(['error' => 'No image uploaded'], 400);
//     }
// }


    // public function store_rental(Request $request)
    // {
    //     // Retrieve the authenticated user's ID
    //     $user_id = Auth::id();
    
    //     // Retrieve the request data
    //     $reference_number = $request->input('reference_number');
    //     $end_date = $request->input('end_date');
    //     $start_date = now()->addDays(5)->format('Y-m-d');
    //     $accommodation_id = $request->input('accommodation_id');
        
    //     // Retrieve the uploaded image file
    //     $image = $request->file('img');
    
    //     // Check if an image was uploaded
    //     if ($image) {
    //         // Generate a unique name for the image
    //         $imageName = time() . '_' . $image->getClientOriginalName();
    
    //         // Store the image in the storage directory
    //         $imagePath = $image->storeAs('public/receipts', $imageName);
    
    //         // Create the rental record with the image path
    //         Rental::create([
    //             'start_date' => $start_date,
    //             'end_date' => $end_date,
    //             'reference_number' => $reference_number,
    //             'user_id' => $user_id,
    //             'accommodations_id' => $accommodation_id,
    //             'receipt' => $imagePath,
    //             'confirmed' => 0,
    //         ]);
    
    //         // Return a response indicating success
    //         return response()->json(['message' => 'Rental created successfully'], 201);
    //     } else {
    //         // If no image was uploaded, return an error response
    //         return response()->json(['error' => 'No image uploaded'], 400);
    //     }
    // }

    public function showRentals()
    {
            $rentals = Rental::all();
            $users = User::all();
    
            return response()->json(['rentals' => $rentals, 'users' => $users], 200);
    }

    public function refuse(Rental $rental)
    {
    $rental->update(['confirmed' => false]);
    $rental->save();

    return redirect()->back()->with('success', 'Service refused.');
     }
     public function confirm(Rental $rental)
     {

    $rental->update(['confirmed' => true]);

        $accommodation = $rental->accommodation;
        $noOfTenantsAvailable = $accommodation->no_of_tenants_available;
        if ($noOfTenantsAvailable > 0) {
            $noOfTenantsAvailable--;
        }
        $accommodation->no_of_tenants_available = $noOfTenantsAvailable;
        $accommodation->save();
        
    return response()->json([
        'success' => true,
        'message' => 'Rental confirmed successfully.',
    ]);
     }

    
// public function confirm(Rental $rental)
// {
//     $rental->update(['confirmed' => true]);
//     //$accommodation = Accommodation::findOrFail($id);
//     //$accommodation->confirmAvailability();
// //     return redirect()->back()->with('success', 'Rental confirmed successfully.');
// // }
// return response()->json([
//     'success' => true,
//     'message' => 'success', 'Rental confirmed successfully.',
// ]);

// }

// public function confirm(Rental $rental)
// {
//     $rental->update(['confirmed' => true]);

//     $accommodation = $rental->accommodation;

//     // Decrease no_of_tenants_available by 1
//     $accommodation = $rental->accommodation;

//     // Ensure accommodation exists
//     if ($accommodation) {
//         // Get the current number of tenants
//         $noOfTenants = $accommodation->no_of_tenants;

//         // Calculate the new number of available tenants
//         $noOfTenantsAvailable = max(0, $noOfTenants - 1);

//         // Update the number of available tenants
//         $accommodation->update(['no_of_tenants_available' => $noOfTenantsAvailable]);

//         // If no_of_tenants_available is 0, set availability to false
//         if ($noOfTenantsAvailable <= 0) {
//             $accommodation->update(['availability' => 0]);
//         }
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Rental confirmed successfully.',
//     ]);
// }


// public function confirm(Rental $rental)
// {
//     $rental->update(['confirmed' => true]);

//     // Get the associated accommodation
//     $accommodation = $rental->accommodation;

//     // Update the number of tenants available
//     if ($accommodation) {
//         $noOfTenantsAvailable = max(0, $accommodation->no_of_tenants_available - 1);
//         $accommodation->update(['no_of_tenants_available' => $noOfTenantsAvailable]);

//         // If no tenants are available, set availability to false
//         if ($noOfTenantsAvailable <= 0) {
//             $accommodation->update(['availability' => false]);
//         }
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'Rental confirmed successfully.',
//     ]);
// }


// public function confirm(Rental $rental)
// {
    // $accommodation = $rental->accommodation;
// Update the confirmed status of the rental
// $rental->update(['confirmed' => true]);

// // Update the number of tenants available (only if it's not already zero)
// $accommodation = $rental->accommodation;
// if ($accommodation->no_of_tenants_available > 0) {
//     $noOfTenantsAvailable = max(0, $accommodation->no_of_tenants_available - 1);

//     if ($noOfTenantsAvailable === 0) {
//         $availability = 'not_available';
//     } else {
//         $availability = 'available';
//     }

//     $accommodation->update([
//         'no_of_tenants_available' => $noOfTenantsAvailable,
//         'availability' => $availability,
//     ]);
// }

// Update the confirmed status of the rental
// $rental->update(['confirmed' => true]);

// // Update the number of tenants available (only if it's not already zero)
// $accommodation = $rental->accommodation;
// $noOfTenantsAvailable = $accommodation->no_of_tenants_available;

// if ($noOfTenantsAvailable > 0) {
//     // $noOfTenantsAvailable = $noOfTenantsAvailable - 1;
//     $noOfTenantsAvailable--;
//     $availability = $noOfTenantsAvailable === 0 ? 'not_available' : 'available';

//     $accommodation->update([
//         'no_of_tenants_available' => $noOfTenantsAvailable,
//         'availability' => $availability,
//     ]);
// }

// $accommodation = $rental->accommodation;
//     $noOfTenantsAvailable = $accommodation->no_of_tenants_available;

//     // Decrement the number of tenants available if it's not already zero
//     if ($noOfTenantsAvailable > 0) {
//         $noOfTenantsAvailable--;
//     }

//     // Ensure the number of tenants available does not go below 0
//     $noOfTenantsAvailable = max($noOfTenantsAvailable, 0);

//     // Update the availability based on the number of tenants available
//     $availability = $noOfTenantsAvailable === 0 ? 'not_available' : 'available';

//     // Update the accommodation with the new values
//     $accommodation->update([
//         'no_of_tenants_available' => $noOfTenantsAvailable,
//         'availability' => $availability,
//     ]);

//     return response()->json([
//         'success' => true,
//         'message' => 'Rental confirmed successfully.',
//     ]);
// }



// public function confirm(Rental $rental)
// {
//     $accommodation = $rental->accommodation;
//     if ($accommodation->no_of_tenants_available > 0) {
//         $rental->update(['confirmed' => true]);
//         $accommodation->no_of_tenants_available--;
//         $accommodation->save();
//     }

//     return response()->json([
//         'success' => true,
//         'message' => 'success', 'Rental confirmed successfully.',
//     ]);
// }



public function showUserData($userId)
    {
        // Get the user data from the rental
        $user = $this->getUserDataFromRental($userId);

        if ($user) {
            // Return user data, or pass it to a view, etc.
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }

    private function getUserDataFromRental($userId)
    {
        // Find the rentals by user_id
        $rental = Rental::where('user_id', $userId)->first();

        // Get the user data associated with the rental
        if ($rental) {
            $user = $rental->user;
            return $user;
        } else {
            return null; // or handle the case where no rental is found
        }
    }
    public function getByAccommodationId($accommodation_id)
{
    // Assuming Rental is your model and rentals table has accommodation_id column
    $rentals = Rental::where('accommodations_id', $accommodation_id)
                     ->get()
                     ->where('confirmed', 1)
                     ->toArray();
    // if ($rentals->isEmpty()) {
    //                     return response()->json(['message' => 'No confirmed rentals found for this accommodation.'], 404);
    //                 }

    return response()->json($rentals);
}

}