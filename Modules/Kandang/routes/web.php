<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('master-data')->as('master-data.')->group(function() {
        Route::resource('kandang', KandangController::class)->names('kandang')->except('show');
    });
});
