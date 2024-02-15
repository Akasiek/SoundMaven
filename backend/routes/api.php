<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
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
        Route::get('/{param}', [AlbumController::class, 'show']);
        Route::put('/{param}', [AlbumController::class, 'update']);
        Route::patch('/{param}', [AlbumController::class, 'update']);
        Route::delete('/{album}', [AlbumController::class, 'destroy']);
    });

    Route::controller(ArtistController::class)->prefix('artists')->group(function () {
        Route::get('/', [ArtistController::class, 'index']);
        Route::post('/', [ArtistController::class, 'store']);
        Route::get('/{param}', [ArtistController::class, 'show']);
        Route::put('/{param}', [ArtistController::class, 'update']);
        Route::patch('/{param}', [ArtistController::class, 'update']);
        Route::delete('/{artist}', [ArtistController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
