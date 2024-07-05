<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Owner;
use App\Models\User;
use App\Models\Accommodation;
use App\Models\Rental;
use Illuminate\Support\Facades\Auth;

class FilterController extends Controller
{
    public function search(Request $request)
    {
        $search_text = $request->get('query');
        $accommodations = Accommodation::where('description', 'like', '%' . $search_text . '%')->get();
        return view('accommodation', ['accommodations' => $accommodations]);
    }
    // public function serarch(){
    //     //$search_text = request('query');
    //     $search_text = $_GET('query');
    //     $accommodations = Accommodation::where('description', 'like', '%' . $search_text . '%')->get();
    //     return view('accommodation', ['accommodations' => $accommodations]);
    // }
    // public function filter(Request $request)
    // {
    //     $region = $request->input('region');
    //     $maxPrice = $request->input('maxPrice');
    //     $city = $request->input('city');
    //     $type = $request->input('type');

    //     $query = Accommodation::query();

    //     if ($region) {
    //         $query->where('region', $region);
    //     }

    //     if ($maxPrice) {
    //         $query->where('price', '<=', $maxPrice);
    //     }

    //     if ($city) {
    //         $query->where('governorate', $city);
    //     }

    //     if ($type) {
    //         $query->where('shared_or_individual', $type);
    //     }

    //     $secondHomes = $query->get();

    //     return view('filter', ['secondHomes' => $secondHomes]);
    // }
    // public function filter(Request $request)
    // {
    //     $region = $request->input('region');
    //     $maxPrice = $request->input('maxPrice');
    //     $city = $request->input('city');
    //     $type = $request->input('type');

    //     $query = Accommodation::query();

    //     if ($region) {
    //         $query->where('region', $region);
    //     }

    //     if ($maxPrice) {
    //         $query->where('price', '<=', $maxPrice);
    //     }

    //     if ($city) {
    //         $query->where('governorate', $city);
    //     }

    //     if ($type) {
    //         $query->where('shared_or_individual', $type);
    //     }

    //     return view('filter', ['query' => $query]);
    // }

    // public function filteredAccommodations(Request $request)
    // {
    //     $query = $request->input('query');

    //     $accommodations = $query->get();

    //     return view('filtered-accommodations', ['accommodations' => $accommodations]);
    // }
    //     public function filteredAccommodations(Request $request, $query)
    // {
    //     $query = $request->input('query');
    //     $accommodations = $query->get();
    //     return view('filtered-accommodations', ['accommodations' => $accommodations]);
    // }

    public function showFilterForm()
    {

        return view('filter');
    }

    public function filter(Request $request)
    {
        $query = Accommodation::query();

        if ($request->filled('district')) {
            $query->where('region', $request->input('district'));
        }

        if ($request->filled('price')) {
            $query->where('price', '<=', $request->input('price'));
        }

        if ($request->filled('city')) {
            $query->where('governorate', $request->input('city'));
        }

        if ($request->filled('searchType')) {
            $query->where('shared_or_individual', $request->input('searchType'));
        }

        $accommodations = $query->get();
        //testing the images
        // $accommodation = Accommodation::where('id', 4)->first();
        // $images = $accommodation->images;
        // foreach ( as $image) {
        //     $images[] = asset('storage/' . $image); // Adjust the path accordingly
        // }
        // Override the casting behavior for the images column in this controller
        //$accommodationi = Accommodation::all();
        // $accommodation->setCasts(['images' => 'string']);
        // $accommodation->offsetExists(['images' => 'string']);
        // $images = [];

        // foreach ($accommodationi as $accommodation) {
        //     $images[$accommodation->id] = $accommodation->images;
        // } // correct


        // foreach ($accommodationi as $accommodation) {
        //     // Retrieve images for each accommodation
        //     $accommodationImages = [];
        //     foreach ($accommodation->images as $image) {
        //         $accommodationImages[] = asset('storage/' . $image); // Adjust the path accordingly
        //     }
        //     // $first = head($accommodationImages);
        //     $images[$accommodation->id] = $accommodationImages;
        // }
        // $images = $accommodationi->map(function ($accommodationie) {
        //     return $accommodationie->images;
        // });

        // Now the images column will be treated as a string, not an array
        // $images = $accommodationi->images;
        // $first = head($images->toArray());
        //$test = Accommodation::find(15);

        // Access a specific element from the images array
        // $tests = $test->images;
        // $first = $tests[2];
        // $first=Accommodation::whereJsonContains('images', ['z'])->first(); //failed
        // $first = data_get($images, '1');
        // 'first'=>$first
        // , 'images' => $images,'first'=>$first
        // return response()->json(['accommodations' => $accommodations]);



        // $accommodationsData = $accommodations
        // ->map(function ($accommodation) {
        //     return [
        //         'description' => $accommodation->description,
        //         'governorate' => $accommodation->governorate,
        //         'region' => $accommodation->region,
        //         'price' => $accommodation->price,
        //         'main_image' => $accommodation->main_image,
        //     ];
        // });
        return response()->json(['accommodations' => $accommodations]);
        // return view('filtered-accommodations', ['accommodations' => $accommodations]);
    }

    // public function showAll()
    // {
    //     $accommodations = Accommodation::all();
    //     $images = [];

    //     foreach ($accommodations as $accommodation) {
    //         // Retrieve images for each accommodation
    //         $accommodationImages = [];
    //         foreach ($accommodation->images as $image) {
    //             $accommodationImages[] = asset('storage/' . $image); // Adjust the path accordingly
    //         }
    //         $images[$accommodation->id] = $accommodationImages;
    //     }

    //     return view('all-accommodations', compact('accommodations', 'images'));
    // }
}
