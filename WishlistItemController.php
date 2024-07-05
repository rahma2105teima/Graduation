<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Models\User;
use App\Models\Accommodation;

class WishlistItemController extends Controller
{
    public function store(Request $request, Accommodation $accommodation)
    {
        // Get the authenticated user
        $user = auth()->user();

        // Get or create the user's wishlist
        $wishlist = $user->wishlist;
        if (!$wishlist) {
            $wishlist = new Wishlist(['user_id' => $user->id]);
            $wishlist->save();
        }

        // Check if the accommodation is already in the wishlist
        $existingItem = WishlistItem::where('wishlist_id', $wishlist->id)
                                    ->where('accommodation_id', $accommodation->id)
                                    ->first();

        if (!$existingItem) {
            // Add the accommodation to the wishlist
            $wishlistItem = new WishlistItem([
                'wishlist_id' => $wishlist->id,
                'accommodation_id' => $accommodation->id,
            ]);
            $wishlistItem->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Accommodation added to wishlist successfully.',
            'wishlistItem' => $wishlistItem
        ], 200);    }

    public function destroy(Accommodation $accommodation)
    {
        $wishlist = auth()->user()->wishlist;

        $deletedRows = $wishlist->items()->where('accommodation_id', $accommodation->id)->delete();

        if ($deletedRows) {
            return response()->json([
                'success' => true,
                'message' => 'Accommodation removed from wishlist successfully.'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Accommodation not found in wishlist.'
            ], 404);
        }    }
}