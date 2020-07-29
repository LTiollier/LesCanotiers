<?php

use Illuminate\Support\Facades\Route;

Route::prefix('filters')->name('filters.')->group(function () {
    Route::post('/filter', 'FilterController@filter')->name('filter');

    Route::get('/{filter_name}', 'FilterController@index')->name('index');
    Route::post('/', 'FilterController@store')->name('store');
    Route::delete('/{filter}', 'FilterController@destroy')->name('destroy');
});
