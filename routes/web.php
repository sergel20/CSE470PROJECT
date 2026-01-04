<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Homepage with property gallery
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public property show route (guest listing detail)
use App\Models\Property;
Route::get('/properties/{property}', function (Property $property) {
    return view('properties.show', compact('property'));
})->name('properties.show');

// Public user profile (view-only)
Route::get('/profiles/{user}', [ProfileController::class, 'show'])->name('profile.show');

// All routes that require authentication
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user && $user->role === 'guest') {
            return view('guest.message', ['message' => 'You are a guest']);
        }

        // Hosts get host dashboard
        if ($user && $user->role === 'host') {
            $controller = app(\App\Http\Controllers\HostDashboardController::class);
            return $controller->index();
        }

        return view('dashboard');
    })->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Listing routes
    Route::resource('listings', ListingController::class);

    // Booking routes
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

    // Host availability: block/unblock dates for a property
    Route::post('/properties/{property}/blocks', [App\Http\Controllers\HostAvailabilityController::class, 'store'])->name('properties.blocks.store');
    Route::delete('/properties/{property}/blocks/{block}', [App\Http\Controllers\HostAvailabilityController::class, 'destroy'])->name('properties.blocks.destroy');

    // Notification routes (FR-3)
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/properties/{id}/review', 
    [ReviewController::class, 'store']
    )->middleware('auth');
});
