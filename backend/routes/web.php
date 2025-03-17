<?php

use App\Livewire\{AlbumView, ArtistList, ArtistView, Welcome};

Route::get('/', Welcome::class)->name('home');

Route::name('artist.')->group(function () {
    Route::get('/artists', ArtistList::class)->name('index');
    Route::get('/artists/{artistId}', ArtistView::class)->name('show');
});

Route::name('album.')->group(function () {
    Route::get('/albums/{albumId}', AlbumView::class)->name('show');
});
