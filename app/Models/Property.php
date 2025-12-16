<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = [
        'host_id', 'title', 'description', 'price', 'rating', 'featured', 'photo'
    ];

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
