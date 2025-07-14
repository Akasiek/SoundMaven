<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumReviewController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(ArtistController::class)->prefix('artists')->group(function() {
    Route::get('/', 'index')->name('artists.list');
    Route::get('/fetch', 'fetchRaw')->name('artists.fetchRaw');
    Route::get('/{artist:slug}', 'show')->name('artists.show');
});

Route::controller(AlbumController::class)->prefix('albums')->group(function() {
    Route::get('/', 'index')->name('albums.list');
    Route::get('/{album:slug}', 'show')->name('albums.show');
});

Route::controller(AlbumReviewController::class)->prefix('album-reviews')->group(function() {
    Route::post('/', 'store')->name('album-reviews.store');
    Route::delete('/{albumReview}', 'destroy')->name('album-reviews.destroy');
});

Route::controller(UserController::class)->prefix('users')->group(function() {
    Route::get('/{user:slug}', 'show')->name('users.show');
});

include __DIR__ . '/auth.php';
