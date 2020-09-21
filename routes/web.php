<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::blacklist(function () {
        Route::get('login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::get('password/reset/{token}', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    });
    Route::post('login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.create');
    Route::get('logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
    Route::get('password/reset', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [\App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\TimeController::class, 'index'])->name('home');

    /**
     * FILTERS
     */
    Route::prefix('filters')->name('filters.')->group(function () {
        Route::post('/csv-export', [\App\Http\Controllers\FilterController::class, 'export'])->name('export');
    });

    /**
     * USERS
     */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'delete'])->name('delete');
    });

    /**
     * VEGETABLE CATEGORIES
     */
    Route::prefix('vegetable-categories')->name('vegetableCategories.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VegetableCategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\VegetableCategoryController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\VegetableCategoryController::class, 'store'])->name('store');
        Route::get('/{vegetableCategory}/edit', [\App\Http\Controllers\VegetableCategoryController::class, 'edit'])->name('edit');
        Route::put('/{vegetableCategory}', [\App\Http\Controllers\VegetableCategoryController::class, 'update'])->name('update');
        Route::delete('/{vegetableCategory}', [\App\Http\Controllers\VegetableCategoryController::class, 'delete'])->name('delete');
    });

    /**
     * VEGETABLES
     */
    Route::prefix('vegetables')->name('vegetables.')->group(function () {
        Route::get('/', [\App\Http\Controllers\VegetableController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\VegetableController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\VegetableController::class, 'store'])->name('store');
        Route::get('/{vegetable}/edit', [\App\Http\Controllers\VegetableController::class, 'edit'])->name('edit');
        Route::put('/{vegetable}', [\App\Http\Controllers\VegetableController::class, 'update'])->name('update');
        Route::delete('/{vegetable}', [\App\Http\Controllers\VegetableController::class, 'delete'])->name('delete');
    });

    /**
     * PARCELS
     */
    Route::prefix('parcels')->name('parcels.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ParcelController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ParcelController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\ParcelController::class, 'store'])->name('store');
        Route::get('/{parcel}/edit', [\App\Http\Controllers\ParcelController::class, 'edit'])->name('edit');
        Route::put('/{parcel}', [\App\Http\Controllers\ParcelController::class, 'update'])->name('update');
        Route::delete('/{parcel}', [\App\Http\Controllers\ParcelController::class, 'delete'])->name('delete');
    });

    /**
     * PARCELS
     */
    Route::prefix('cycles')->name('cycles.')->group(function () {
        Route::get('/', [\App\Http\Controllers\CycleController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\CycleController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\CycleController::class, 'store'])->name('store');
        Route::get('/{cycle}/edit', [\App\Http\Controllers\CycleController::class, 'edit'])->name('edit');
        Route::put('/{cycle}', [\App\Http\Controllers\CycleController::class, 'update'])->name('update');
        Route::delete('/{cycle}', [\App\Http\Controllers\CycleController::class, 'delete'])->name('delete');
    });
});
