<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CycleController;
use App\Http\Controllers\ParcelController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TimeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VegetableCategoryController;
use App\Http\Controllers\VegetableController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::blacklist(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    });
    Route::post('login', [LoginController::class, 'login'])->name('login.create');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::resources([
        'users' => UserController::class,
        'times' => TimeController::class
    ], ['except' => ['show']]);


    Route::middleware('role:' . User::_ROLE_ADMIN)->group(function () {
        Route::resources([
            'cycles' => CycleController::class,
            'parcels' => ParcelController::class,
            'vegetables' => VegetableController::class,
            'vegetableCategories' => VegetableCategoryController::class,
            'activities' => ActivityController::class
        ], ['except' => ['show']]);


        Route::get('/report/export/{startsAt?}/{endsAt?}', [ReportController::class, 'exportCycles'])->name('cycles.report.export');
        Route::get('/report/{startsAt?}/{endsAt?}', [ReportController::class, 'index'])->name('report');
        Route::get('/cycles/{cycle}/export', [ReportController::class, 'exportCycle'])->name('cycles.report');
    });

    Route::redirect('/', route('times.create'))->name('home');
});
