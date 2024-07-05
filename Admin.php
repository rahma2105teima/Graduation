<?php

// namespace App\Models;

// use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Str;
// use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\Relations\MorphMany;
// use Laravel\Sanctum\PersonalAccessToken;

// class Admin extends Authenticatable
// {
//     use HasFactory, Notifiable , HasApiTokens;

//     /**
//      * The attributes that are mass assignable.
//      *
//      * @var array
//      */
//     protected $fillable = [
//         'name', 'email', 'password', 'phone', 'photo',
//     ];

//     /**
//      * The attributes that should be hidden for arrays.
//      *
//      * @var array
//      */
//     protected $hidden = [
//         'password', 'remember_token',
//     ];

//  protected $casts = [
//         'email_verified_at' => 'datetime',
//         'password' => 'hashed',
//     ];
//     /**
//      * The attributes that should be cast to native types.
//      *
//      * @var array
//      */
    

//     //  public function createToken($name)
//     // {
//     //     return $this->tokens()->create([
//     //         'name' => $name,
//     //         'token' => Str::random(60),
//     //         'expires_at' => now()->addWeeks(1),
//     //     ]);
//     // }

//     // public function createToken($name, $abilities = ['*'])
//     // {
//     //     return $this->tokens()->create([
//     //         'name' => $name,
//     //         'token' => hash('sha256', Str::random(40)),
//     //         'abilities' => $abilities,
//     //     ]);
//     // }

//     // public function createToken($name)
//     // {
//     //     return $this->tokens()->create([
//     //         'name' => $name,
//     //         'token' => Str::random(60),
//     //         'expires_at' => now()->addWeeks(1),
//     //     ]);
//     // }
//     public function tokens(): MorphMany
//     {
//         return $this->morphMany(PersonalAccessToken::class, 'tokenable');
//     }

//     public function createToken($name): PersonalAccessToken
//     {
//         return $this->tokens()->create([
//             'name' => $name,
//             'token' => hash('sha256', Str::random(40)), // Adjust token generation as needed
//             'abilities' => ['*'], // Adjust abilities as needed
//         ]);
//     }
// }

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\PersonalAccessToken;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'photo',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

   
//     public function tokens(): MorphMany
//     {
//         return $this->morphMany(PersonalAccessToken::class, 'tokenable');
//     }

//     /**
//  * Generate a new personal access token for the admin.
//  *
//  * @param string $name
//  * @return string
//  */
// public function generatePersonalToken(string $name): string    {
//         $token = hash('sha256', Str::random(80));

//         $this->tokens()->create([
//             'name' => $name,
//             'token' => $token,
//             'abilities' => ['*'],
//         ]);

//         return $token;
//     }
}