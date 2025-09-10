<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckUserAccess;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\RateplanController;
use App\Http\Controllers\BookingController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [App\Http\Controllers\InterfaceController::class, 'main'])->name('main');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth', CheckUserAccess::class])->group(function () {
    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Destination routes
    Route::get('/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
    Route::post('/destinations', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/destinations/{id}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::get('/destinations/{id}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
    Route::put('/destinations/{id}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/destinations/{id}', [DestinationController::class, 'destroy'])->name('destinations.destroy');

    // Tour routes
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/create', [TourController::class, 'create'])->name('tours.create');
    Route::post('/tours', [TourController::class, 'store'])->name('tours.store');
    Route::get('/tours/{id}', [TourController::class, 'show'])->name('tours.show');
    Route::get('/tours/{id}/edit', [TourController::class, 'edit'])->name('tours.edit');
    Route::put('/tours/{id}', [TourController::class, 'update'])->name('tours.update');
    Route::delete('/tours/{id}', [TourController::class, 'destroy'])->name('tours.destroy');

    // Rate plan routes
    Route::get('/rateplans', [RateplanController::class, 'index'])->name('rateplans.index');
    Route::get('/rateplans/create', [RateplanController::class, 'create'])->name('rateplans.create');
    Route::post('/rateplans', [RateplanController::class, 'store'])->name('rateplans.store');
    Route::get('/rateplans/{id}', [RateplanController::class, 'show'])->name('rateplans.show');
    Route::get('/rateplans/{id}/edit', [RateplanController::class, 'edit'])->name('rateplans.edit');
    Route::put('/rateplans/{id}', [RateplanController::class, 'update'])->name('rateplans.update');
    Route::delete('/rateplans/{id}', [RateplanController::class, 'destroy'])->name('rateplans.destroy');

    // Booking routes
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{id}/edit', [BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{id}', [BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('bookings.destroy');

    // Booking AJAX routes
    Route::get('/bookings/tour/{tourId}/rateplans', [BookingController::class, 'getRatePlans'])->name('bookings.rateplans');
    Route::post('/bookings/calculate-pricing', [BookingController::class, 'calculatePricing'])->name('bookings.calculate');
    Route::post('/bookings/search', [BookingController::class, 'search'])->name('bookings.search');
    Route::post('/bookings/{id}/update-status', [BookingController::class, 'updateBookingStatus'])->name('bookings.update-status');
    Route::post('/bookings/{id}/update-payment-status', [BookingController::class, 'updatePaymentStatus'])->name('bookings.update-payment-status');
    Route::post('/bookings/upload-receipt', [BookingController::class, 'uploadReceipt'])->name('bookings.upload-receipt');
});

// Interface routes for beach tours
Route::prefix('interface')->name('interface.')->group(function () {
    Route::get('/', [App\Http\Controllers\InterfaceController::class, 'main'])->name('main');
    Route::get('/tours/{destination?}', [App\Http\Controllers\InterfaceController::class, 'tours'])->name('tours');
    Route::get('/tours/{destination}/{type}', [App\Http\Controllers\InterfaceController::class, 'toursByType'])->name('toursByType'); 
    Route::get('/details/{id}', [App\Http\Controllers\InterfaceController::class, 'details'])->name('details');
    Route::post('/book', [App\Http\Controllers\InterfaceController::class, 'book'])->name('book');
    Route::post('/pricing', [App\Http\Controllers\InterfaceController::class, 'pricing'])->name('pricing');
    Route::get('/search', [App\Http\Controllers\InterfaceController::class, 'search'])->name('search');
    Route::post('/change-language', [App\Http\Controllers\InterfaceController::class, 'changeLanguage'])->name('changeLanguage');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/seo.php';
