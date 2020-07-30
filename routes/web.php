<?php

use Illuminate\Support\Facades\Route;

Route::namespace('Auth')->group(function () {
    Route::blacklist(function () {
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    });
    Route::post('login', 'LoginController@login')->name('login.create');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
});

Route::middleware('auth')->group(function () {

    /**
     * FILTERS
     */
    Route::prefix('filters')->name('filters.')->group(function () {
        Route::post('/csv-export', 'FilterController@export')->name('export');
    });

    /**
     * USERS
     */
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', 'UserController@index')->name('index');
        Route::get('/create', 'UserController@create')->name('create');
        Route::post('/', 'UserController@store')->name('store');
        Route::get('/{user}/edit', 'UserController@edit')->name('edit');
        Route::put('/{user}', 'UserController@update')->name('update');
        Route::delete('/{user}', 'UserController@delete')->name('delete');
    });

    /**
     * VEGETABLES
     */
    Route::prefix('vegetables')->name('vegetables.')->group(function () {
        Route::get('/', 'VegetableController@index')->name('index');
        Route::get('/create', 'VegetableController@create')->name('create');
        Route::post('/', 'VegetableController@store')->name('store');
        Route::get('/{vegetable}/edit', 'VegetableController@edit')->name('edit');
        Route::put('/{vegetable}', 'VegetableController@update')->name('update');
        Route::delete('/{vegetable}', 'VegetableController@delete')->name('delete');
    });
});
