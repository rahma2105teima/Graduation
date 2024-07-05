<?php

namespace App\Models;
use App\Models\User;
use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['rating','user_id','accommodation_id','review'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class,'accommodation_id');
    }
    
}
