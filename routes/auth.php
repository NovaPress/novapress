<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('register', 'showRegister')->name('register')->name('register');
        Route::post('register', 'register')->name('register');
        Route::get('login', 'showLogin')->name('login');
        Route::post('login', 'login');
        Route::get('forgot-password', 'showPasswordResetLink')->name('password.request');
        Route::post('forgot-password', 'passwordResetLink')->name('password.email');
        Route::get('reset-password/{token}', 'showPasswordReset')->name('password.reset');
        Route::post('reset-password', 'passwordReset')->name('password.store');
    });
    Route::middleware('auth')->group(function () {
        Route::get('verify-email', 'showEmailVerification')->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', 'verifyEmail')
            ->middleware(['signed', 'throttle:6,1'])
            ->name('verification.verify');
        Route::post('email/verification-notification', 'sendEmailVerification')
            ->middleware('throttle:6,1')
            ->name('verification.send');
        Route::get('confirm-password', 'showConfirmPassword')->name('password.confirm');
        Route::post('confirm-password', 'confirmPassword');
        Route::put('password', 'updatePassword')->name('password.update');
        Route::post('logout', 'logout')->name('logout');
    });
});
