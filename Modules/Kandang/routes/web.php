<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\Dashboard\DashboardController;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('master-data')->as('master-data.')->group(function() {
        Route::resource('kandang', KandangController::class)->names('kandang')->except('show');
        Route::resource('flock', FlockController::class)->names('flock')->except('show');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');
    });
});
