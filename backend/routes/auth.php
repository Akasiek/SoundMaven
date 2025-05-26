<?php

use App\Http\Controllers\Auth\{EmailVerificationController, LoginController, RegisterController, ResetPasswordController};

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'displayRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.request');

    Route::get('login', [LoginController::class, 'displayLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.request');

    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('forgot-password', 'displayForgotPasswordForm')->name('forgot-password');
        Route::post('forgot-password', 'forgotPassword')->name('forgot-password.request');
        Route::get('reset-password/{token}', 'displayResetPasswordForm')->name('reset-password');
        Route::post('reset-password', 'resetPassword')->name('reset-password.request');
    });
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::controller(EmailVerificationController::class)->group(function () {
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
