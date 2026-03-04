<?php

use Illuminate\Support\Facades\Route;

use Modules\GudangPakan\Http\Controllers\MasterData\BahanBakuController;

Route::middleware(['auth'])
    ->prefix('gudang-pakan')
    ->as('gudang-pakan.')
    ->group(function () {

        Route::prefix('master-data')
            ->as('master-data.')
            ->group(function() {
                Route::resource('bahan-baku', BahanBakuController::class)->names('bahan-baku');
            });

    });
