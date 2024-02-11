<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
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

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/logout', 'logout');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('albums', AlbumController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
