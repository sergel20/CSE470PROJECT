<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    // ... other properties and methods

    /**
     * Relationship: a user can have many wishlist items.
     */
    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}

