<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AccommodationController;
use App\Http\Controllers\Auth\OwnerProfileController;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\rentalController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistItemController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ServiceListController;
use App\Http\Controllers\DeactivatedAccountController;
use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\CheckApiToken;
use App\Http\Middleware\OwnerMiddleware;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

   

    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    // Route::post('/accommodation', [AccommodationController::class, 'store'])
    ->middleware('auth:sanctum');


Route::post('/accommodationform', [AccommodationController::class, 'store'])
->middleware('auth:sanctum');


Route::get('/accommodationform', [AccommodationController::class, 'create'])
->middleware('auth:sanctum');

Route::get('/accommodationsofowner', [AccommodationController::class, 'index'])->middleware('auth:sanctum','auth.owner');
Route::get('/accommodations/{id}/edit', [AccommodationController::class, 'edit'])->middleware('auth:sanctum','auth.owner');
Route::put('/accommodations/{id}', [AccommodationController::class, 'update'])->middleware('auth:sanctum','auth.owner');
Route::delete('accommodations/{id}',[AccommodationController::class, 'destroy'])->middleware('auth:sanctum','auth.owner');

Route::middleware('auth:sanctum')->get('/accommodations', [AccommodationController::class, 'showSome']);


// Route::get('accommodation/{id}', [AccommodationController::class, 'show']);
Route::get('accommodation/{accommodation_id}', [AccommodationController::class, 'show']);

Route::get('/owner',function (Request $request){
    return $request->user();
})->middleware('auth:sanctum');

// Route::middleware(['auth:api'])->group(function () {
//     Route::post('/accommodation', [AccommodationController::class, 'store']);

    // Route::get('/owner/profile', [OwnerProfileController::class, 'show']);
// });

// Route::middleware([ApiMiddleware::class])->post('/accommodation', [AccommodationController::class, 'store']);
// In routes/api.php
// Route::middleware(['auth:api', ApiMiddleware::class])->post('/accommodation', [AccommodationController::class, 'store']);

// Route::get('/owner/profile/edit', [OwnerProfileController::class, 'edit']);
// Route::put('/owner/profile/{owner}/update', [OwnerProfileController::class, 'update']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('show');
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('edit');
    Route::put('/user/profile/{id}/update', [UserProfileController::class, 'update'])->name('update');
    Route::get('/owner/profile', [OwnerProfileController::class, 'show']);
    Route::get('/owner/profile/edit', [OwnerProfileController::class, 'edit']);
    Route::put('/owner/profile/{id}/update', [OwnerProfileController::class, 'update'])->name('owner.profile.update');
});

Route::get('/recommendation_system_output', [RecommendationController::class ,'recommendAreas'])->middleware('auth:sanctum');

Route::get('/rental/{accommodation_id}', [RentalController::class, 'index'])->middleware('auth:sanctum');

Route::post('/rental', [RentalController::class, 'store_rental'])->middleware('auth:sanctum');

// Route::get('/owneraccept', [rentalController::class, 'showRentals'])->middleware('auth:sanctum');
Route::get('/owneraccept', [rentalController::class, 'showRentals']);


//Route::put('rentals/{rental}/confirm', [rentalController::class, 'confirm']);

Route::get('/filter', [FilterController::class, 'showFilterForm']);
Route::get('/filtered-accommodations', [FilterController::class, 'filter']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist/{accommodation}', [WishlistItemController::class, 'store']);
    Route::delete('wishlist/{accommodation}', [WishlistItemController::class, 'destroy']);
});

Route::get('/rental/user/{userId}', [RentalController::class, 'showUserData']);
Route::get('/accommodationsome', [AccommodationController::class, 'showSomee']);
// Authenticated routes for API
Route::get('/allusers', [AdminController::class, 'getAllUsers']);
Route::delete('/role-delete/{id}', [AdminController::class, 'registerdelete']);
Route::get('/allowners', [AdminController::class, 'index']);
Route::delete('/owners/{id}', [AdminController::class, 'destroy']);
Route::put('/rentals/{rental}/confirm', [rentalController::class, 'confirm']);

Route::put('/rentals/{rental}/refuse', [rentalController::class, 'refuse']);

Route::get('/allaccommodations', [AccommodationController::class, 'showall']);
Route::delete('/deleteaccommodation/{id}', [AccommodationController::class, 'destroys']);


Route::middleware('auth:sanctum')->group(function () {

// Route::put('/rentals/{rental}/confirm', [rentalController::class, 'confirm']);

// Route::put('/rentals/{rental}/refuse', [rentalController::class, 'refuse']);
// Route::get('/allusers', [AdminController::class, 'getAllUsers']);


// Route::delete('/role-delete/{id}', [AdminController::class, 'registerdelete']);

// Route::get('/allowners', [AdminController::class, 'index']);
// Route::delete('/owners/{id}', [AdminController::class, 'destroy']);



// Route::put('/rentals/{rental}/confirm', [rentalController::class, 'confirm']);

// Route::put('/rentals/{rental}/refuse', [rentalController::class, 'refuse']);


// Route::get('deactivated-accounts/{user}', [DeactivatedAccountController::class, 'show'])->name('api.deactivated_accounts.show');
// Route::delete('/deactivated-accounts/{id}', [DeactivatedAccountController::class, 'destroy']);
});

//marie added
Route::get('/rental_accommodation_id/{accommodation_id}', [RentalController::class, 'getByAccommodationId']);

Route::middleware('auth:sanctum')->group(function () { 
    Route::post('/ratings', [RatingController::class, 'store']); 
    Route::get('/ratings/{id}', [RatingController::class, 'show']); // Show ratings for specific accommodation 
 
});