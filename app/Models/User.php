<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-profile.png');
    }

    /**
     * Listings owned by the user (host).
     * FR‑4: Hosts can toggle active/inactive on these listings.
     */
    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }

    /**
     * Bookings made by the user (guest).
     * FR‑20: Guests can view their booking history.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'guest_id');
    }

    /**
     * Bookings received by the host on their listings.
     * FR‑18: Hosts manage booking requests.
     */
    public function hostBookings(): HasMany
    {
        return $this->hasManyThrough(
            Booking::class,
            Listing::class,
            'user_id',   // Foreign key on listings table
            'listing_id', // Foreign key on bookings table
            'id',        // Local key on users table
            'id'         // Local key on listings table
        );
    }

    /**
     * Wishlist items saved by the user (guest).
     * FR‑21: Guests can save listings.
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Helper: check if user is a host.
     */
    public function isHost(): bool
    {
        return $this->role === 'host';
    }

    /**
     * Helper: check if user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper: check if user is a guest.
     */
    public function isGuest(): bool
    {
        return $this->role === 'guest';
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

}

