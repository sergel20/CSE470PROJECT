<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'listing_id',
        'guest_id',
        'check_in',
        'check_out',
        'guests',
        'nightly_rate',
        'service_fee',
        'total_price',
        'status', // pending | approved | declined
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    /**
     * Relationship: the listing this booking belongs to.
     */
    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class);
    }

    /**
     * Relationship: the guest who made the booking.
     */
    public function guest(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guest_id');
    }

    /**
     * Relationship: the host who owns the listing.
     * Useful for FR‑18 dashboards.
     */
    public function host(): BelongsTo
    {
        return $this->listing()->withDefault()->user();
    }

    /**
     * Scope: only pending bookings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: only approved bookings.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: only declined bookings.
     */
    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    /**
     * Helper: check if booking is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Helper: check if booking is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Helper: check if booking is declined.
     */
    public function isDeclined(): bool
    {
        return $this->status === 'declined';
    }

    /**
     * Approve the booking (FR‑18).
     */
    public function approve(): void
    {
        $this->update(['status' => 'approved']);
    }

    /**
     * Decline the booking (FR‑18).
     */
    public function decline(): void
    {
        $this->update(['status' => 'declined']);
    }
}

