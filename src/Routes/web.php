<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\HomeContoller;
use Mariojgt\Castle\Controllers\WallAutentication;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Middlewhere validation
    Route::post('/castle/validate', [WallAutentication::class, 'tryAutentication'])->name('castle.validate');
});
