<?php
use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\PeternakanController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;
use Modules\Kandang\Http\Controllers\MasterData\StrainAyamController;
use Modules\Kandang\Http\Controllers\Populations\AyamAfkirController;
use Modules\Kandang\Http\Controllers\Populations\SupplierLogController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('master-data')->as('master-data.')->group(function() {
        Route::resource('peternakan', PeternakanController::class)->names('peternakan');
        Route::get('strain-ayam', [StrainAyamController::class, 'index'])->name('strain-ayam.index');
        Route::resource('kandang', KandangController::class)->names('kandang')->except('show');
        Route::resource('flock', FlockController::class)->names('flock')->except('show');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');
        Route::get('flock/{flock}/pipes', [PipeController::class, 'indexByFlock']) ->name('pipe.byFlock');
    });
       Route::resource('supplier-log', SupplierLogController::class)->names('supplier-log');
       Route::resource('ayam-afkir', AyamAfkirController::class)->names('ayam-afkir');
       
});
