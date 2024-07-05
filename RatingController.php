<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
class RatingController extends Controller
{
        public function store(Request $request)
        {
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'accommodation_id' => 'required|integer',
                'rating' => 'nullable|integer|between:1,5',
                'review' => 'nullable|string|max:255',
            ]);
    
            if ($validator->fails()) {
                Log::error('Validation failed: ' . json_encode($validator->errors()));
                return response()->json(['error' => 'Validation failed', 'messages' => $validator->errors()], 422);
            }
    
            if (!Auth::check()) {
                Log::debug('User is not authenticated', ['headers' => $request->headers->all()]);
                return response()->json(['error' => 'Unauthenticated'], 401);
            }
    
            $userId = Auth::id();
            $accommodationId = $request->accommodation_id;
            $ratingValue = $request->rating;
            $review = $request->review;
    
            Log::debug('Request data: ' . json_encode([
                'user_id' => $userId,
                'accommodation_id' => $accommodationId,
                'rating' => $ratingValue,
            ]));
    
            if ($ratingValue === null && $review === null) {
                return response()->json(['error' => 'You cannot leave both the rating and review empty.'], 400);
            }
    
            $rating = new Rating();
            $rating->rating = $ratingValue;
            $rating->user_id = $userId;
            $rating->accommodation_id = $accommodationId;
            $rating->review = $review;
            $rating->save();
    
            Log::info('Rating saved successfully', ['rating_id' => $rating->id]);
    
            return response()->json(['success' => 'Rating added successfully!', 'rating' => $rating], 201);
        }
    
        public function show($id)
        {
            // Find ratings for the specified accommodation ID
            $ratings = Rating::where('accommodation_id', $id)->get();
    
            if ($ratings->isEmpty()) {
                return response()->json(['error' => 'No ratings found for this accommodation'], 404);
            }
    
            return response()->json(['ratings' => $ratings]);
        }
    }
    
