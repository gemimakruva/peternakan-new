<?php

use Illuminate\Support\Facades\Route;
use Modules\GudangTelur\Http\Controllers\MasterData\KemasanController;
use Modules\GudangTelur\Http\Controllers\SupplierController;

Route::middleware(['auth'])
    ->prefix('gudang-telur')
    ->as('gudang-telur.')
    ->group(function () {
        Route::resource('supplier', SupplierController::class)->names('supplier');

        Route::prefix('master-data')
            ->as('master-data.')
            ->group(function() {
                Route::resource('kemasan', KemasanController::class)->names('kemasan');
            });
    });
