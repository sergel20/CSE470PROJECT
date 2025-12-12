<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
     * Get the user that owns the listing.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the main image URL.
     */
    public function getMainImageUrlAttribute()
    {
        return $this->main_image
            ? asset('storage/' . $this->main_image)
            : asset('images/default-property.png');
    }

    /**
     * Get all image URLs.
     */
    public function getImageUrlsAttribute()
    {
        if (!$this->images) {
            return [];
        }
        return array_map(fn($image) => asset('storage/' . $image), $this->images);
    }
}
