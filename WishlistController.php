<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->wishlist->items->load('accommodation');
        return response()->json([
            'success' => true,
            'wishlist' => $wishlist
        ], 200);
    }
}
