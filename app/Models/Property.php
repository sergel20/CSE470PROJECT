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

    public function blockedDates()
    {
        return $this->hasMany(BlockedDate::class);
    }

    // app/Models/Property.php

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function averageRating() {
        return round($this->reviews()->avg('rating'), 1);
    }

}
