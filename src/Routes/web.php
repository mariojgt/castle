<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\WallAutenticationController;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Middlewhere validation Render the autentication page
    Route::post('/castle/validate/2-steps/verification', [WallAutenticationController::class, 'tryAutentication'])
        ->name('castle.validate');
    // Unlock castle code
    Route::post('/castle/unlock/account/backup/code', [WallAutenticationController::class, 'tryUseBackupcode'])
        ->name('castle.unlock.backup.code');
});
