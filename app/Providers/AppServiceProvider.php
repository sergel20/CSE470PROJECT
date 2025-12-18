<?php

namespace App\Providers;

use App\Models\Listing;
use App\Models\Booking;
use App\Policies\ListingPolicy;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Listing::class => ListingPolicy::class,   // FR‑4: toggle active/inactive
        Booking::class => BookingPolicy::class,   // FR‑18: approve/decline bookings
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

