<?php

use App\Http\Controllers\InterfaceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Interface Routes
|--------------------------------------------------------------------------
|
| Here are the routes for the beach tours interface pages
|
*/

Route::prefix('interface')->name('interface.')->group(function () {
    // Main interface page
    Route::get('/', [InterfaceController::class, 'main'])->name('main');
    
    // Tours listing page
    Route::get('/tours/{destination?}', [InterfaceController::class, 'tours'])->name('tours');
    
    // Tour details page
    Route::get('/details/{id}', [InterfaceController::class, 'details'])->name('details');
    
    // Booking endpoints
    Route::post('/book', [InterfaceController::class, 'book'])->name('book');
    Route::post('/pricing', [InterfaceController::class, 'pricing'])->name('pricing');
    
    // Search endpoint
    Route::get('/search', [InterfaceController::class, 'search'])->name('search');
    
    // Language change endpoint
    Route::post('/change-language', [InterfaceController::class, 'changeLanguage'])->name('changeLanguage');
});
