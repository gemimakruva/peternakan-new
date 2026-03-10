<?php

use Illuminate\Support\Facades\Route;

use Modules\GudangPakan\Http\Controllers\BahanPakanFormulasiController;
use Modules\GudangPakan\Http\Controllers\BahanPakanInventoryController;
use Modules\GudangPakan\Http\Controllers\BahanPakanMasukController;
use Modules\GudangPakan\Http\Controllers\BahanPakanPembelianController;
use Modules\GudangPakan\Http\Controllers\MasterData\BahanPakanController;
use Modules\GudangPakan\Http\Controllers\PakanFinishedGoodDistribusiController;
use Modules\GudangPakan\Http\Controllers\PakanFinishedGoodInventoryController;
use Modules\GudangPakan\Http\Controllers\PakanMixingController;
use Modules\GudangPakan\Http\Controllers\PakanPreMixingController;
use Modules\GudangPakan\Http\Controllers\PakanPreMixingInventoryController;
use Modules\GudangPakan\Http\Controllers\SupplierBahanPakanController;

Route::middleware(['auth'])
    ->prefix('gudang-pakan')
    ->as('gudang-pakan.')
    ->group(function () {

        Route::prefix('master-data')
            ->as('master-data.')
            ->group(function() {
                Route::resource('bahan-pakan', BahanPakanController::class)->names('bahan-pakan');
            });

        Route::resource('supplier-bahan-pakan', SupplierBahanPakanController::class)
            ->parameter('supplier-bahan-pakan', 'supplier')->names('supplier-bahan-pakan');

        Route::resource('bahan-pakan-pembelian', BahanPakanPembelianController::class)->names('bahan-pakan-pembelian');
        Route::resource('bahan-pakan-masuk', BahanPakanMasukController::class)->names('bahan-pakan-masuk');
        Route::resource('bahan-pakan-inventory', BahanPakanInventoryController::class)
            ->parameter('bahan-pakan-inventory', 'bahan-pakan')->names('bahan-pakan-inventory')->only(['index', 'show']);

        Route::resource('bahan-pakan-formulasi', BahanPakanFormulasiController::class)->names('bahan-pakan-formulasi');
        Route::resource('pakan-pre-mixing', PakanPreMixingController::class)->names('pakan-pre-mixing');
        Route::resource('pakan-pre-mixing-inventory', PakanPreMixingInventoryController::class)
            ->parameter('pakan-pre-mixing-inventory', 'bahan-pakan-formulasi') ->names('pakan-pre-mixing-inventory')->only(['index', 'show']);
        Route::resource('pakan-mixing', PakanMixingController::class)->names('pakan-mixing');
        Route::resource('pakan-finished-good-inventory', PakanFinishedGoodInventoryController::class)
            ->parameter('pakan-finished-good-inventory', 'bahan-pakan-formulasi')->names('pakan-finished-good-inventory')->only(['index', 'show']);
        Route::resource('pakan-finished-good-distribusi', PakanFinishedGoodDistribusiController::class)->names('pakan-finished-good-distribusi');

    });
