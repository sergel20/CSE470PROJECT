<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = ['photo_url'];

    /**
     * Accessor for profile photo URL.
     */
    public function getPhotoUrlAttribute()
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-profile.png');
    }

    /**
     * Get all listings owned by the user.
     */
    public function listings()
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Feature 5: Get all recent searches made by the user.
     */
    public function recentSearches()
    {
        return $this->hasMany(RecentSearch::class);
    }

    /**
     * Feature 3: Get all bookings where the user is the guest.
     */
    public function bookingsAsGuest()
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    /**
     * Feature 3: Get all bookings where the user is the host.
     */
    public function bookingsAsHost()
    {
        return $this->hasMany(Booking::class, 'host_id');
    }
}
