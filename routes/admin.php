<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Middleware\AdminAuthMiddleware;
use App\Http\Middleware\AdminGuestMiddleware;
use Illuminate\Support\Facades\Route;

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
            Route::get('/', [DashboardController::class, 'index'])->name('index');
            Route::post('/', [DashboardController::class, 'storeDraft'])->name('store-draft');
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');

            // Posts Routes
            Route::controller(PostController::class)->group(function () {
                Route::get('posts', 'index')->name('posts.index');
                Route::get('posts/create', 'create')->name('posts.create');
            });

            // Categories Routes
            Route::controller(CategoryController::class)->group(function () {
                Route::get('categories', 'index')->name('categories.index');
                Route::post('categories', 'store')->name('categories.store');
                Route::get('categories/{category}', 'show')->name('categories.show');
                Route::put('categories/{category}', 'update')->name('categories.update');
                Route::delete('categories/{category}', 'destroy')->name('categories.destroy');
            });

            // Tags Routes
            Route::controller(TagController::class)->group(function () {
                Route::get('tags', 'index')->name('tags.index');
                Route::post('tags', 'store')->name('tags.store');
                Route::get('tags/{tag}', 'show')->name('tags.show');
                Route::put('tags/{tag}', 'update')->name('tags.update');
                Route::delete('tags/{tag}', 'destroy')->name('tags.destroy');
            });

            // Users Routes
            Route::controller(UserController::class)->group(function () {
                Route::get('users', 'index')->name('users.index');
                Route::get('users/add', 'create')->name('users.create');
                Route::post('users', 'store')->name('users.store');
                Route::get('users/{user}', 'show')->name('users.show');
                Route::put('users/{user}', 'update')->name('users.update');
                Route::delete('users/{user}', 'destroy')->name('users.destroy');
                Route::get('profile', 'showProfile')->name('users.profile');
            });

            // Comments Routes
            Route::controller(CommentController::class)->group(function () {
                Route::get('comments', 'index')->name('comments.index');
                Route::get('comments/{comment}', 'show')->name('comments.show');
                Route::put('comments/{comment}', 'update')->name('comments.update');
                Route::delete('comments/{comment}', 'destroy')->name('comments.destroy');

            });
        });
    });
});
