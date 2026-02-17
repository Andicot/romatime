<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth']], function () {

    Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'show']);

    Route::get('/logout', [\App\Http\Controllers\LogOut::class, 'logOut']);
    Route::get('/metronic/{cosa}', [\App\Http\Controllers\LogOut::class, 'metronic']);
});

Route::get('/test', \App\Http\Controllers\TestController::class);
