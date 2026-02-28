<?php

use Illuminate\Support\Facades\Route;
use Modules\GudangTelur\Http\Controllers\KemasanInputController;
use Modules\GudangTelur\Http\Controllers\KemasanInventoryController;
use Modules\GudangTelur\Http\Controllers\KemasanOpnameController;
use Modules\GudangTelur\Http\Controllers\KemasanOutputController;
use Modules\GudangTelur\Http\Controllers\MasterData\AjaxController;
use Modules\GudangTelur\Http\Controllers\MasterData\KemasanController;
use Modules\GudangTelur\Http\Controllers\SupplierController;
use Modules\GudangTelur\Http\Controllers\Telur\TelurInventoryController;
use Modules\GudangTelur\Http\Controllers\Telur\TelurKeluarController;
use Modules\GudangTelur\Http\Controllers\Telur\TelurMasukController;
use Modules\GudangTelur\Http\Controllers\Telur\TelurOpnameController;

Route::middleware(['auth'])
    ->prefix('gudang-telur')
    ->as('gudang-telur.')
    ->group(function () {
        Route::resource('supplier', SupplierController::class)->names('supplier');

        Route::resource('kemasan-input', KemasanInputController::class)->names('kemasan-input');
        Route::resource('kemasan-output', KemasanOutputController::class)->names('kemasan-output');
        Route::resource('kemasan-opname', KemasanOpnameController::class)->names('kemasan-opname');
        Route::get('kemasan-inventory', [KemasanInventoryController::class, 'index'])->name('kemasan-inventory.index');
        Route::get('kemasan-inventory/{kemasanId}', [KemasanInventoryController::class, 'show'])->name('kemasan-inventory.show');

        Route::resource('telur-masuk', TelurMasukController::class)->names('telur-masuk');
        Route::resource('telur-keluar', TelurKeluarController::class)->names('telur-keluar');
        Route::resource('telur-opname', TelurOpnameController::class)->names('telur-opname');
        Route::resource('telur-inventory', TelurInventoryController::class)->names('telur-inventory');

        Route::prefix('master-data')
            ->as('master-data.')
            ->group(function() {
                Route::resource('kemasan', KemasanController::class)->names('kemasan');
            });

        Route::get('ajax/supplier/{supplierId}/kemasan', [AjaxController::class, 'supplierKemasan'])->name('ajax.supplier.kemasan');
    });
