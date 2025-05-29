<?php

use App\Http\Controllers\ArtistController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::controller(ArtistController::class)->prefix('artists')->group(function() {
    // Route::get('/artists', 'index')->name('artists.index');
    Route::get('/{param}', 'show')->name('artists.show');
});

include __DIR__ . '/auth.php';
