<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlist'; // matches your migration

    protected $fillable = [
        'user_id',
        'listing_id',
    ];

    /**
     * Relationship: Wishlist belongs to a User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Wishlist belongs to a Listing.
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }
}


