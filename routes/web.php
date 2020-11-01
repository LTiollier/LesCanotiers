<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    /**
     * FILTERS
     */
    Route::prefix('filters')->name('filters.')->group(function () {
        Route::post('csv-export', [\App\Http\Controllers\FilterController::class, 'export'])->name('export');
    });


    /**
     * CRUD
     */
    Route::crud('UserController', User::class, 'user', ['show'], function () {
        Route::bind('user', function ($value) {
            if ($value === "me") {
                return Auth::guard()->user();
            }
            return User::findOrFail($value);
        });
    });

    Route::crud('VegetableCategoryController', \App\Models\VegetableCategory::class, 'vegetableCategory');
    Route::crud('VegetableController', \App\Models\Vegetable::class, 'vegetable');
    Route::crud('ParcelController', \App\Models\Parcel::class, 'parcel');
    Route::crud('CycleController', \App\Models\Cycle::class, 'cycle');
    Route::crud('ActivityController', \App\Models\Activity::class, 'activity');
    Route::crud('TimeController', \App\Models\Time::class, 'time');

    Route::redirect('/', route('times.create'))->name('home');
});
