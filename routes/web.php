<?php

require __DIR__.'/auth.php';

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Homepage with property gallery
Route::get('/', [HomeController::class, 'index'])->name('home');

// All routes that require authentication
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user && $user->role === 'guest') {
            return view('guest.message', ['message' => 'You are a guest']);
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

    // Notification routes (FR-3)
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});
