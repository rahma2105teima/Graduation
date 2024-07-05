<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\PersonalAccessToken;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'status', 'gender', 'age', 'city', 'where_to_go', 'phone', 'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $guarded = [];
   
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function accommodations()
    {
        return $this->has(Accommodation::class);
    }

    public function wishlist(): HasOne
    {
        return $this->hasOne(Wishlist::class);
    }
    public function ratings() 
    { 
        return $this->hasMany(Rating::class); 
    }

    // public function createToken($name)
    // {
    //     return $this->tokens()->create([
    //         'name' => $name,
    //         'token' => Str::random(60),
    //         'expires_at' => now()->addWeeks(1),
    //     ]);
    // }


    // public function createToken($name, $abilities = ['*'])
    // {
    //     return $this->tokens()->create([
    //         'name' => $name,
    //         'token' => hash('sha256', Str::random(40)),
    //         'abilities' => $abilities,
    //     ]);
    // }

    // public function tokens(): MorphMany
    // {
    //     return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    // }

    // public function createToken($name): PersonalAccessToken
    // {
    //     return $this->tokens()->create([
    //         'name' => $name,
    //         'token' => hash('sha256', Str::random(80)),
    //         'expires_at' => now()->addWeeks(1),
    //     ]);
    // }
}
