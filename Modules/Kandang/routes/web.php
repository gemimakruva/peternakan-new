<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\KandangController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('kandang', KandangController::class)->names('kandang');
});
