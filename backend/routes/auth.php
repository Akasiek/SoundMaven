<?php

use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('register', 'displayRegister')->name('register');
        Route::post('register', 'register');

        Route::get('login', 'displayLogin')->name('login');
        Route::post('login', 'login');
    });
});
