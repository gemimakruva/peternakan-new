<?php
use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\AyamAfkir\AyamAfkirController;
use Modules\Kandang\Http\Controllers\AyamKarantina\AyamKarantinaController;
use Modules\Kandang\Http\Controllers\PopulasiAyam\PopulasiAyamController;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\PeternakanController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;
use Modules\Kandang\Http\Controllers\MasterData\StrainAyamController;
use Modules\Kandang\Http\Controllers\PengadaanAyam\PengadaanAyamController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('master-data')->as('master-data.')->group(function() {
        Route::resource('peternakan', PeternakanController::class)->names('peternakan');
        Route::get('strain-ayam', [StrainAyamController::class, 'index'])->name('strain-ayam.index');
        Route::resource('kandang', KandangController::class)->names('kandang')->except('show');
        Route::resource('flock', FlockController::class)->names('flock')->except('show');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');
        Route::get('flock/{flock}/pipes', [PipeController::class, 'indexByFlock']) ->name('pipe.byFlock');
    });
        Route::resource('pengadaan-ayam', PengadaanAyamController::class)->names('pengadaan-ayam');
        Route::resource('populasi-ayam', PopulasiAyamController::class)->names('populasi-ayam');
        Route::get('populasi-ayam/{pengadaan_ayam}/create', [PopulasiAyamController::class, 'createByDate'])
        ->name('populasi-ayam.createByDate');
        Route::resource('ayam-afkir', AyamAfkirController::class)->names('ayam-afkir');
        Route::resource('ayam-karantina', AyamKarantinaController::class)->names('ayam-karantina');
});
