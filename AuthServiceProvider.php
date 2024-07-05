<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Owner;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
//     public function boot(): void
// {

//     // $this->registerPolicies();

//     // // Check if the API token is valid for an owner
//     // $this->app->booted(function () {
//     //     $this->registerOwnerApiTokenPolicy();
//     // });

//     // // Allow requests with a valid X-API-TOKEN header to pass through the gate
//     // Gate::define('api-owner', function ($user) {
//     //     return $user && $user->api_token === request()->header('X-API-TOKEN');
//     // });
//     Gate::define('api-owner', function ($apiToken) {
//         return Owner::where('api_token', $apiToken)->exists();
//     });
//     $this->registerPolicies();

//     // Check if the API token is valid for an owner
//     $this->app->booted(function () {
//         $this->registerOwnerApiTokenPolicy();
//     });



//     // Gate::define('api-owner', function ($apiToken) {
//     //     return Owner::where('api_token', $apiToken)->exists();
//     // });

// }

public function boot(): void
{
    $this->registerPolicies();

    Gate::define('api-owner', function ($apiToken) {
        return Owner::where('api_token', $apiToken)->exists();
    });

    $this->app->booted(function () {
        $this->registerOwnerApiTokenPolicy();
    });
}
private function registerOwnerApiTokenPolicy(): void
    {
        //
    }
}
