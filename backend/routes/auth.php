<?php

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');
    //
    // Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthController::class, 'displayLogin'])
        ->name('login');

    Route::post('login', [AuthController::class, 'login']);


});
