<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;
    protected $fillable =[
        'start_date',
        'end_date',
        'reference_number',
        'user_id',
        'accommodations_id',
        'receipt',
        'confirmed',

    ];
    public function user()//:BelongsTo
    {
        return $this->belongsTo(related: User::class, foreignKey: 'user_id')->withDefault();

    }
    public function accommodation()//:BelogsTo
    {
        return $this->belongsTo(related: Accommodation::class, foreignKey:'accommodations_id')->withDefault();
    }


   
    // public function updateNoOfTenantsAvailable(int $noOfTenantsAvailable): void
    // {
    //     $this->no_of_tenants_available = $noOfTenantsAvailable;
    //     $this->save();
    // }
}
