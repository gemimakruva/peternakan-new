<?php

use Illuminate\Support\Facades\Route;
use Modules\GudangTelur\Http\Controllers\SupplierController;

Route::middleware(['auth'])
    ->prefix('gudang-telur')
    ->as('gudang-telur.')
    ->group(function () {
        Route::resource('supplier', SupplierController::class)->names('supplier');
    });
