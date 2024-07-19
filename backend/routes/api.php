<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AlbumReviewController;
use App\Http\Controllers\AlbumTagController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\TrackController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return "Hi!";
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AlbumController::class)->prefix('albums')->group(function () {
        Route::get('/', [AlbumController::class, 'index']);
        Route::post('/', [AlbumController::class, 'store']);
        Route::get('/{albumParam}', [AlbumController::class, 'show']);
        Route::put('/{albumParam}', [AlbumController::class, 'update']);
        Route::patch('/{albumParam}', [AlbumController::class, 'update']);
        Route::delete('/{album}', [AlbumController::class, 'destroy']);

        Route::get('/{albumParam}/tracks', [AlbumController::class, 'showTracks']);
        Route::get('/{albumParam}/reviews', [AlbumController::class, 'showReviews']);

        Route::get('/{albumParam}/genres', [AlbumController::class, 'showGenres']);
        Route::post('/{albumParam}/genres/{genreParam}', [AlbumController::class, 'attachGenre']);
        Route::delete('/{albumParam}/genres/{genreParam}', [AlbumController::class, 'detachGenre']);

        Route::get('/{albumParam}/tags', [AlbumController::class, 'showTags']);
        Route::post('/{albumParam}/tags/{tagParam}', [AlbumController::class, 'attachTag']);
        Route::delete('/{albumParam}/tags/{tagParam}', [AlbumController::class, 'detachTag']);
    });

    Route::controller(ArtistController::class)->prefix('artists')->group(function () {
        Route::get('/', [ArtistController::class, 'index']);
        Route::post('/', [ArtistController::class, 'store']);
        Route::get('/{param}', [ArtistController::class, 'show']);
        Route::put('/{param}', [ArtistController::class, 'update']);
        Route::patch('/{param}', [ArtistController::class, 'update']);
        Route::delete('/{artist}', [ArtistController::class, 'destroy']);
    });

    Route::controller(TrackController::class)->prefix('tracks')->group(function () {
        Route::get('/', [TrackController::class, 'index']);
        Route::post('/', [TrackController::class, 'store']);
        Route::get('/{trackParam}', [TrackController::class, 'show']);
        Route::put('/{trackParam}', [TrackController::class, 'update']);
        Route::patch('/{trackParam}', [TrackController::class, 'update']);
        Route::delete('/{track}', [TrackController::class, 'destroy']);
    });

    Route::controller(GenreController::class)->prefix('genres')->group(function () {
        Route::get('/', [GenreController::class, 'index']);
        Route::post('/', [GenreController::class, 'store']);
        Route::get('/{genreParam}', [GenreController::class, 'show']);
        Route::put('/{genreParam}', [GenreController::class, 'update']);
        Route::patch('/{genreParam}', [GenreController::class, 'update']);
        Route::delete('/{genre}', [GenreController::class, 'destroy']);

        Route::get('/{genreParam}/albums', [GenreController::class, 'showAlbums']);
    });

    Route::controller(AlbumReviewController::class)->prefix('album-reviews')->group(function () {
        Route::get('/', [AlbumReviewController::class, 'index']);
        Route::post('/', [AlbumReviewController::class, 'store']);
        Route::get('/{albumReview}', [AlbumReviewController::class, 'show']);
        Route::put('/{albumReview}', [AlbumReviewController::class, 'update']);
        Route::patch('/{albumReview}', [AlbumReviewController::class, 'update']);
        Route::delete('/{albumReview}', [AlbumReviewController::class, 'destroy']);
    });

    Route::controller(AlbumTagController::class)->prefix('album-tags')->group(function () {
        Route::get('/', [AlbumTagController::class, 'index']);
        Route::post('/', [AlbumTagController::class, 'store']);
        Route::get('/{albumTag}', [AlbumTagController::class, 'show']);
        Route::put('/{albumTag}', [AlbumTagController::class, 'update']);
        Route::patch('/{albumTag}', [AlbumTagController::class, 'update']);
        Route::delete('/{albumTag}', [AlbumTagController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
