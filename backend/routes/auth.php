<?php

use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', 'displayRegister')->name('register');
        Route::post('register', 'register');

        Route::get('login', 'displayLogin')->name('login');
        Route::post('login', 'login');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', 'displayVerificationEmailPrompt')
            ->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', 'verifyEmail')
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', 'sendVerificationEmail')
            ->middleware('throttle:6,1')
            ->name('verification.send');
    });
});

Route::get('/profile', function () {
    // Only verified users may access this route...
    return Inertia\Inertia::render('profile/Index', [
        'user' => auth()->user(),
    ]);
})->middleware(['auth', 'verified']);
