<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Accommodation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'description', 'address', 'location_link',
        'governorate', 'region', 'facilities',
        'price', 'shared_or_individual',
        // 'availability',                                     //edited
        'images','main_image', 'owner_id',
        'no_of_tenants',
    ];         //added don't forget to make 'no_of_tenants' and 'no_of_tenants_available' == 'no_of_tenants'

    protected $casts = [
        'images' => 'array',
    ];
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function getAvailabilityAttribute()
    {
        return $this->no_of_tenants_available > 0 ? 'available' : 'not_available';
    }


    // public function confirmAvailability()
    // {
    //     if ($this->shared_or_individual === 'individual') {
    //         $this->is_available = false;           //availability column
    //     } elseif ($this->shared_or_individual === 'shared'&& $this->no_of_tenants_available !=0) {
    //         $this->no_of_tenants_available -= 1;

    //         if ($this->no_of_tenants_available === 0) {
    //             $this->is_available = false;
    //         }
    //     }

    //     $this->save();
    // }

    public function rentals()
{
    return $this->hasMany(Rental::class);
}
//     public function confirmAvailability()
// {
//     if ($this->shared_or_individual === 'individual') {
//         $this->is_available = false;
//     } elseif ($this->shared_or_individual === 'shared') {
//         $this->no_of_tenants_available -= 1;

//         if ($this->no_of_tenants_available === 0) {
//             $this->is_available = false;
//         }
//     }

//     $this->save();
// }

// Accommodation.php (Model)
public function isAvailable()
{
    return $this->no_of_tenants_available > 0;
}

public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function ratings() 
    { 
        return $this->hasMany(Rating::class); 
    }


}
