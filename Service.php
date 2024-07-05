<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description','image', 'reference_number', 'end_date', 'accepted',
        
    ];

    // Optional: Define relationships or additional methods here
}
