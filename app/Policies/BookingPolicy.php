<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can manage (approve/decline) the booking.
     * FR‑18: Only the host who owns the listing or an admin can do this.
     */
    public function manage(User $user, Booking $booking): bool
    {
        return $user->id === $booking->listing->user_id || $user->role === 'admin';
    }
}
