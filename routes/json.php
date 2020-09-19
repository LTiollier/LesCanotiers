<?php

use Illuminate\Support\Facades\Route;

Route::prefix('filters')->name('filters.')->group(function () {
    Route::post('/filter', [\App\Http\Controllers\Json\FilterController::class, 'filter'])->name('filter');

    Route::get('/{filter_name}', [\App\Http\Controllers\Json\FilterController::class, 'index'])->name('index');
    Route::post('/', [\App\Http\Controllers\Json\FilterController::class, 'store'])->name('store');
    Route::delete('/{filter}', [\App\Http\Controllers\Json\FilterController::class, 'destroy'])->name('destroy');
});
