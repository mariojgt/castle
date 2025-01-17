<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\WallAuthenticationController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // middleware validation Render the authentication page
    Route::post('/castle/validate/2-steps/verification', [WallAuthenticationController::class, 'tryAuthentication'])
        ->name('castle.validate')->middleware(['recaptcha']);
    // Unlock castle code
    Route::post('/castle/unlock/account/backup/code', [WallAuthenticationController::class, 'tryUseBackupCode'])
        ->name('castle.unlock.backup.code')->middleware(['recaptcha']);

    // Render the view that display the castle wall
    Route::view('/castle/wall', 'castle::content.authentication.index')->name('castle.wall');
});
