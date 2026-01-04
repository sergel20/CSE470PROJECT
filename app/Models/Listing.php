<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
        'latitude',
        'longitude',
        'property_type',
        'guest_capacity',
        'bedrooms',
        'bathrooms',
        'price_per_night',
        'amenities',
        'main_image',
        'images',
        'status',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'price_per_night' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get the user (host) that owns the listing.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bookings for this listing.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Blocked dates for this listing.
     */
    public function blockedDates(): HasMany
    {
        return $this->hasMany(BlockedDate::class);
    }

    /**
     * Relationship: wishlist entries for this listing.
     * FR‑21: Guests can save listings.
     */
    public function wishlistedBy(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Scope: only active listings.
     * FR‑4: Guests should only see active listings in search.
     */
    public function scopeActive($query)
    {
        return $query->where(function ($q) {
            $q->where('status', 'active')
              ->orWhere('is_active', true);
        });
    }

    /**
     * Helper: check if listing is active.
     */
    public function isActive(): bool
    {
        return $this->is_active || $this->status === 'active';
    }

    /**
     * Helper: check if listing is inactive.
     */
    public function isInactive(): bool
    {
        return !$this->is_active || $this->status === 'inactive';
    }

    /**
     * Get the main image URL.
     */
    public function getMainImageUrlAttribute(): string
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/default-property.png');
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute(): array
    {
        if (!$this->images) {
            return [];
        }
        return array_map(fn($image) => asset('storage/' . $image), $this->images);
    }
}

