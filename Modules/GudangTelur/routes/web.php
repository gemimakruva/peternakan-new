<?php

use Illuminate\Support\Facades\Route;
use Modules\GudangTelur\Http\Controllers\KemasanInputController;
use Modules\GudangTelur\Http\Controllers\KemasanInventoryController;
use Modules\GudangTelur\Http\Controllers\MasterData\AjaxController;
use Modules\GudangTelur\Http\Controllers\MasterData\KemasanController;
use Modules\GudangTelur\Http\Controllers\SupplierController;

Route::middleware(['auth'])
    ->prefix('gudang-telur')
    ->as('gudang-telur.')
    ->group(function () {
        Route::resource('supplier', SupplierController::class)->names('supplier');

        Route::resource('kemasan-input', KemasanInputController::class)->names('kemasan-input');
        Route::resource('kemasan-inventory', KemasanInventoryController::class)->names('kemasan-inventory');

        Route::prefix('master-data')
            ->as('master-data.')
            ->group(function() {
                Route::resource('kemasan', KemasanController::class)->names('kemasan');
            });

        Route::get('ajax/supplier/{supplierId}/kemasan', [AjaxController::class, 'supplierKemasan'])->name('ajax.supplier.kemasan');
    });
