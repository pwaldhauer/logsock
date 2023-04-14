<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/', 'App\Http\Controllers\LogController@store')->name('log.store');
    Route::post('/', 'App\Http\Controllers\LogController@store')->name('log.store');
});
