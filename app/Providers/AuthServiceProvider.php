<?php

namespace App\Providers;

use App\Models\Listing;
use App\Models\Booking;
use App\Policies\ListingPolicy;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Listing::class => ListingPolicy::class,   // FR‑4: toggle active/inactive listings
        Booking::class => BookingPolicy::class,   // FR‑18: approve/decline bookings
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Register the policies defined above
        $this->registerPolicies();

        // Example global gate: allow admins to bypass all checks
        Gate::before(function ($user, $ability) {
            return $user->role === 'admin' ? true : null;
        });
    }
}
