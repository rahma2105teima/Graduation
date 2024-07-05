<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserProfileController;
use App\Http\Controllers\Auth\OwnerProfileController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AccommodationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\rentalController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistItemController;
use App\Http\Controllers\Auth\LogoutController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name(name:'homy');

// Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');


// Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [RegisterController::class, 'register']);
// Route::get('/registration/message', [RegisterController::class, 'showRegistrationMessage'])->name('register.message');
// Route::get('/login/message', [LoginController::class, 'showloginMessage'])->name('login.message');
// Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [LoginController::class, 'login']);

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('/registration/message', [RegisteredUserController::class, 'showRegistrationMessage'])->name('register.message');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    
});

Route::middleware(['auth', 'auth:owner'])->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    
});



// Route::post('/accommodation', [AccommodationController::class, 'store'])->name('accommodation.store');

// Route::get('/accommodation/prop', [AccommodationController::class, 'showAll'])->name('accommodation.showAll');
// Route::middleware('auth:sanctum')->get('/accommodations', [AccommodationController::class, 'showAll']);

Route::get('/upload/message', [ AccommodationController::class, 'showuploadMessage'])->name('upload.message');
// Route::get('accommodation/{id}', [AccommodationController::class, 'show'])->name('image.show');
Route::get('accommodation/{accommodation_id}', [AccommodationController::class, 'show'])->name('image.show');


// Route::get('/accommodationform', [AccommodationController::class, 'create'])->name('accommodation.create');

// Route::post('/accommodationform', [AccommodationController::class, 'store'])->name('accommodation.store');
// Route::get('/accommodationform', [AccommodationController::class, 'create'])->name('accommodation.create');

Route::middleware(['auth:owner'])->group(function () {
    Route::get('/accommodationsofowner', [AccommodationController::class, 'index'])->name('accommodations.index');
    Route::get('/accommodations/{id}/edit', [AccommodationController::class, 'edit'])->name('accommodations.edit');
    Route::put('/accommodations/{id}', [AccommodationController::class, 'update'])->name('accommodations.update');
    Route::delete('accommodations/{id}',[AccommodationController::class, 'destroy'])->name('accommodations.destroy');
    Route::post('/accommodationform', [AccommodationController::class, 'store'])->name('accommodation.store');
    Route::get('/accommodationform', [AccommodationController::class, 'create'])->name('accommodation.create');
});


Route::get('/csrf-token', function() {
    return response()->json(['token' => csrf_token()]);
});

//Route::get('/user/profile', [UserProfileController::class, 'show'])->name('user.profile');
Route::middleware(['auth:owner'])->group(function () {
Route::get('/owner/profile', [OwnerProfileController::class, 'show'])->name('owner.profile');
Route::get('/owner/profile/edit', [OwnerProfileController::class, 'edit'])->name('owner.edit');
Route::put('/owner/profile/{id}/update', [OwnerProfileController::class, 'update'])->name('owner.update');
});

//Route::get('/userprofile/edit',[UserProfileController::class, 'edit'])->name('profile.edit');
//Route::put('/userprofile/{id}/update',[UserProfileController::class, 'update'])->name('profile.update');
Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/user/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/user/profile/{id}/update', [UserProfileController::class, 'update'])->name('profile.update');
});

//Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
//Route::get('accommodations', [AccommodationController::class,'index'])->name('accommodations.index');
// Route::middleware('auth')->group(function () {
//     // Routes that require authentication
// });


// Route::get('/index', [rentalController::class, 'index'])->name('index');

Route::get('/rental/{accommodation_id}', [RentalController::class, 'index'])->name('rental.index');

// Route::get('/home',function(){
//     return view('accommodation');})->name(name:'home');
// Route::post('/index', [rentalController::class, 'store_rental'])->name(name: 'store');
Route::post('/rental', [RentalController::class, 'store_rental'])->name('store.rental');

Route::get('/recommendation_system_output', [RecommendationController::class ,'recommendAreas'])->name('recommend');


Route::get('/owneraccept', [rentalController::class, 'showRentals'])->name(name: 'owner');
Route::put('rentals/{rental}/confirm', [rentalController::class, 'confirm'])->name('rental.confirm');


Route::get('/filter', [FilterController::class, 'showFilterForm'])->name('filter.form');
Route::get('/filtered-accommodations', [FilterController::class, 'filter'])->name('filter');

Route::middleware('auth')->group(function () {
    Route::get('wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('wishlist/{accommodation}', [WishlistItemController::class, 'store'])->name('wishlist.items.store');
    Route::delete('wishlist/{accommodation}', [WishlistItemController::class, 'destroy'])->name('wishlist.items.destroy');
});


//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
