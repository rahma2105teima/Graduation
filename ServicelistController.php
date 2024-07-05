<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Rental;
use App\Models\Accommodation;
use Illuminate\Http\Request;

class ServiceListController extends Controller
{
    /**
     * Display a listing of the services.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $services = Service::all();
        return view('admin.service_list.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.service_list.create');
    }

    public function confirm(Rental $rental)
{

    $rental->update(['confirmed' => true]);

        $accommodation = $rental->accommodation;
        $noOfTenantsAvailable = $accommodation->no_of_tenants_available;

        // Decrement the number of tenants available if it's not already zero
        if ($noOfTenantsAvailable > 0) {
            $noOfTenantsAvailable--;
        }

        // Update the accommodation with the new number of tenants available
        $accommodation->no_of_tenants_available = $noOfTenantsAvailable;
        $accommodation->save();
        
    return response()->json([
        'success' => true,
        'message' => 'Rental confirmed successfully.',
    ]);
}


public function refuse(Rental $rental)
{
    $rental->update(['confirmed' => false]);
    $rental->save();

    return redirect()->back()->with('success', 'Service refused.');
}


   


    /**
     * Remove the specified service from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    // public function destroy(Rental $rental)
    // {
    //     $rental->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Service deleted successfully.',
    //     ]);

    // }

}
