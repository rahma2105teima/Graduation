<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;

class RecommendationController extends Controller
{
    public function recommendAreas(Request $request)
    {
        // $userOrigin = "Luxor";
        // $userDestination = "Aswan";

        // Retrieve the authenticated user
        $user = Auth::user();

        // Ensure user has origin and destination attributes
        if (!$user || !$user->city || !$user->where_to_go) {
            return response()->json(['error' => 'User origin and destination not found.'], 400);
        }

        $userOrigin = $user->city;
        $userDestination = $user->where_to_go;
        // Execute the Python script
        // $process = new Process(['python', 'C:\Users\Alaa\Desktop\try\signlogin\recommendation_system.py', $userOrigin, $userDestination]);
        $pythonExecutable = 'C:\Users\Alaa\Desktop\try\signlogin\myenv\Scripts\python.exe';
        $process = new Process([$pythonExecutable, 'C:\Users\Alaa\Desktop\try\signlogin\recommendation_system.py', $userOrigin, $userDestination]);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }


        $jsonData = file_get_contents('C:\Users\Alaa\Desktop\try\signlogin\public\recommendation_output.json');
        $recommendedAreas = json_decode($jsonData, true);
        //$is_available= ; //>>>>>>>    store the result of availability       <<<<<<<<<<< if condition
        // // $accommodations = Accommodation::where('is_available', true)
        // $accommodations = Accommodation::
        //     whereIn('region', $recommendedAreas)
        //     ->orderByRaw("FIELD(region, '" . implode("','", $recommendedAreas) . "')") //sort results based on elem from array
        //     ->get();
        // $accommodations = Accommodation::whereIn('region', $recommendedAreas)
        // ->orderByRaw("FIELD(region, '" . implode("','", $recommendedAreas) . "')")
        //     ->get()
        //     ->filter(function($accommodation) {
        //         return $accommodation->isAvailable();
        //     });
    
        // // return view('recommendation_system_output', ['recommendations' => $recommendedAreas], ['accommodations' => $accommodations]);
        // return response()->json([
        //     'recommendations' => $recommendedAreas,
        //     'accommodations' => $accommodations,
        // ], 200);


        $accommodations = Accommodation::whereIn('region', $recommendedAreas)
            ->orderByRaw("FIELD(region, '" . implode("','", $recommendedAreas) . "')")
            ->get()
            ->filter(function($accommodation) {
                return $accommodation->isAvailable();
            })
            // ->map(function ($accommodation) {
            //     return [
            //         'governorate' => $accommodation->governorate,
            //         'region' => $accommodation->region,
            //         'price' => $accommodation->price,
            //         'main_image' => $accommodation->main_image,
            //     ];
            // })
            // ->values()
            ->toArray();

        return response()->json(['accommodations' => $accommodations]);
        
    }

}
