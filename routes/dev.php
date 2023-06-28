<?php

// The route file holds the system-related routes for the application,
// handling navigation and functionality specific to the system.

// System Route...

// Initialize System Route...
Route::get('site/initialize-systems', [App\Http\Controllers\Admin\System\LibController::class, 'systems']);

// Applicaton Authentication Verification Route...
Auth::routes(['verify' => false]);

// Application Storage Link Route...
Route::get('/sym', function () {
    File::link(storage_path('app/public'), public_path('storage'));

    return response()->json('Link Create Successfully!');
});

// Application Cache Clear Route...
Route::get('/clear', function () {
    Artisan::call('optimize:clear');

    return response()->json('Cache Cleared Successfully!');
});

// Code Playground Route...
Route::get('code', function () {
    // Code Here!
});
