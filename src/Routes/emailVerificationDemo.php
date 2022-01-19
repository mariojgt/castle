<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\Demo\EmailVerificationController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Render the index view
    Route::get('/castle/email/index', [EmailVerificationController::class, 'index'])->name('castle.email.index');
    // THe request that will generate a email with a code
    Route::post('/castle/email/generate', [EmailVerificationController::class, 'generate'])
        ->name('castle.email.generate');
    // Check if the code is valid
    Route::post('/castle/email/check', [EmailVerificationController::class, 'check'])
        ->name('castle.email.check');
});

// Auth Route Example
Route::group([
    'middleware' => ['web', '2fa'],
], function () {
});
