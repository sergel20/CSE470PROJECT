<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\User;

class ListingPolicy
{
    /**
     * Determine whether the user can update the listing.
     */
    public function update(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the listing.
     */
    public function delete(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id || $user->role === 'admin';
    }

    /**
     * Determine whether the user can toggle active/inactive status (FR‑4).
     */
    public function toggleActive(User $user, Listing $listing): bool
    {
        return $user->id === $listing->user_id || $user->role === 'admin';
    }
}

