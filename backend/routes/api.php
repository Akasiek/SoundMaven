<?php

use App\Http\Controllers\AlbumController;
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
    Route::controller(AlbumController::class)->group(function () {
        Route::get('/', [AlbumController::class, 'index']);
        Route::post('/', [AlbumController::class, 'store']);
        Route::get('/{param}', [AlbumController::class, 'show']);
        Route::put('/{param}', [AlbumController::class, 'update']);
        Route::delete('/{album}', [AlbumController::class, 'destroy']);
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
