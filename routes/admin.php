<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AdminGuestMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use Inertia\Inertia;

// Admin Routes
Route::name('admin.')->group(function () {
    Route::prefix('admin')->group(function () {
        // Auth Routes
        Route::middleware(AdminGuestMiddleware::class)->group(function () {
            Route::get('login', [AuthController::class, 'showLogin'])->name('login');
            Route::post('login', [AuthController::class, 'login'])->name('login.post');
            Route::get('forgot-password', [AuthController::class, 'showPasswordResetLink'])->name('password.request');
            Route::post('forgot-password', [AuthController::class, 'passwordResetLink'])->name('password.email');
            Route::get('reset-password/{token}', [AuthController::class, 'showPasswordReset'])->name('password.reset');
            Route::post('reset-password', [AuthController::class, 'passwordReset'])->name('password.update');
        });

        Route::middleware(AdminAuthMiddleware::class)->group(function () {
            Route::get('/', DashboardController::class)->name('index');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');

            // Posts Routes
            Route::controller(PostController::class)->group(function () {
                Route::get('posts', 'index')->name('posts.index');
            });
        });
    });
});
