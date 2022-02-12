<?php

use Illuminate\Support\Facades\Route;
use Mariojgt\Castle\Controllers\WallAutentication;

// Standard
Route::group([
    'middleware' => ['web'],
], function () {
    // Middlewhere validation Render the autentication page
    Route::post('/castle/validate/2-steps/verification', [WallAutentication::class, 'tryAutentication'])
        ->name('castle.validate');
    // Unlock castle code
    Route::post('/castle/unlock/account/backup/code', [WallAutentication::class, 'tryUseBackupcode'])
        ->name('castle.unlock.backup.code');
});
