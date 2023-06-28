<?php

use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

// Website Route...
Route::group([], function () {
    Route::get('/', [WebsiteController::class, 'index'])->name('home');
});

// Admin Route...
Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/nsl-admin', [App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('nsl_admin');
    Route::post('/nsl-login', [App\Http\Controllers\Auth\AdminLoginController::class, 'login']);
    Route::get('/login-check', [App\Http\Controllers\Auth\AdminLoginController::class, 'loginCheck'])->name('loginCheck');
});
