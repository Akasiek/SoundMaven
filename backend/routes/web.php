<?php

use App\Livewire\{ArtistList, ArtistView, Welcome};

Route::get('/', Welcome::class)->name('home');

Route::name('artist.')->group(function () {
    Route::get('/artists', ArtistList::class)->name('index');
    Route::get('/artists/{artist}', ArtistView::class)->name('show');
});
