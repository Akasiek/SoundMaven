<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumReviewController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(ArtistController::class)->prefix('artists')->group(function() {
    Route::get('/', 'index')->name('artists.list');
    Route::get('/{artist:slug}', 'show')->name('artists.show');
});

Route::controller(AlbumController::class)->prefix('albums')->group(function() {
    Route::get('/', 'index')->name('albums.list');
    Route::get('/{album:slug}', 'show')->name('albums.show');
});

Route::controller(AlbumReviewController::class)->prefix('album-reviews')->group(function() {
    Route::post('/', 'store')->name('album-reviews.store');
});

include __DIR__ . '/auth.php';
