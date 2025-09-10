<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SitemapController;

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
|
| Here are the SEO-related routes for sitemaps and other SEO functionality
|
*/

// Sitemap routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap.index');
Route::get('/sitemap-static.xml', [SitemapController::class, 'static'])->name('sitemap.static');
Route::get('/sitemap-destinations.xml', [SitemapController::class, 'destinations'])->name('sitemap.destinations');
Route::get('/sitemap-tours.xml', [SitemapController::class, 'tours'])->name('sitemap.tours');
Route::get('/sitemap-images.xml', [SitemapController::class, 'images'])->name('sitemap.images');
