<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\HomeContoller;
use Mariojgt\Castle\Controllers\WallAutentication;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Example page not required to be login
    Route::get('/castle', [HomeContoller::class, 'index'])->name('castle');
    // Generate the code
    Route::post('/castle-generate', [HomeContoller::class, 'generate'])->name('castle.generate');
    // Check generated code
    Route::post('/castle-check', [HomeContoller::class, 'checkCode'])->name('castle.check');
    // Logout
    Route::get('/castle/logout', [HomeContoller::class, 'logout'])->name('castle.logout');
});

// Auth Route Example
Route::group([
    'middleware' => ['web', 'wall'],
], function () {
    // Example page required to be login
    Route::get('/castle-try', [HomeContoller::class, 'protected'])->name('castle.try');
});
