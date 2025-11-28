<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::middleware('guest')->group(function() {
    Route::get('register', [RegisterController::class, 'displayRegisterForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register'])->name('register.request');

    Route::get('login', [LoginController::class, 'displayLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.request');

    Route::controller(ResetPasswordController::class)->group(function() {
        Route::get('forgot-password', 'displayForgotPasswordForm')->name('password.request');
        Route::post('forgot-password', 'forgotPassword')->name('password.email');
        Route::get('reset-password/{token}', 'displayResetPasswordForm')->name('password.reset');
        Route::post('reset-password', 'resetPassword')->name('password.store');
    });
});

Route::middleware('auth')->group(function() {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::controller(EmailVerificationController::class)->group(function() {
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
