<?php

// use App\Livewire\{AlbumView, ArtistList, ArtistView, Welcome};

// Route::get('/', Welcome::class)->name('home');
//
// Route::name('artist.')->group(function () {
//     Route::get('/artists', ArtistList::class)->name('index');
//     Route::get('/artists/{artistId}', ArtistView::class)->name('show');
// });
//
// Route::name('album.')->group(function () {
//     Route::get('/albums/{albumId}', AlbumView::class)->name('show');
// });


use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
});

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
