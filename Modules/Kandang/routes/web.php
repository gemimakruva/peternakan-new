<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\AyamAfkir\AyamAfkirController;
use Modules\Kandang\Http\Controllers\AyamKarantina\AyamKarantinaController;
use Modules\Kandang\Http\Controllers\Disinfektan\JenisDisinfektanController;
use Modules\Kandang\Http\Controllers\Disinfektan\PenjadwalanDisinfektanController;
use Modules\Kandang\Http\Controllers\MasterData\AjaxController;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\PeternakanController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;
use Modules\Kandang\Http\Controllers\MasterData\StrainAyamController;
use Modules\Kandang\Http\Controllers\OvkPakan\OvkPakanController;
use Modules\Kandang\Http\Controllers\PengadaanAyam\PengadaanAyamController;
use Modules\Kandang\Http\Controllers\penjadwalanTreatment\PenjadwalanTreatmentController;
use Modules\Kandang\Http\Controllers\Perhitungan_pakan\JenisPakanController;
use Modules\Kandang\Http\Controllers\Perhitungan_pakan\PerhitunganPakanController;
use Modules\Kandang\Http\Controllers\PopulasiAyam\PopulasiAyamController;
use Modules\Kandang\Http\Controllers\RecordingTelur\RecordingTelurController;
use Modules\Kandang\Http\Controllers\SamplingAyam\SamplingAyamController;
use Modules\Kandang\Http\Controllers\treatment\JenisTreatmentController;
use Modules\Kandang\Http\Controllers\treatment\MetodeTreatmentController;

Route::middleware(['auth'])->group(function () {
    Route::prefix('master-data')->as('master-data.')->group(function () {
        Route::resource('peternakan', PeternakanController::class)->names('peternakan');
        Route::resource('Jenis-pakan', JenisPakanController::class)->names('jenis-pakan');
        Route::resource('jenis-disinfectan', JenisDisinfektanController::class)->
        names('jenis-disinfectan');
        Route::resource('jenis-treatment', JenisTreatmentController::class)->
        names('jenis-treatment');
        Route::resource('metode-treatment', MetodeTreatmentController::class)->
        names('metode-treatment');
        Route::get('strain-ayam', [StrainAyamController::class, 'index'])->name('strain-ayam.index');
        Route::resource('kandang', KandangController::class)->names('kandang')->except('show');
        Route::resource('flock', FlockController::class)->names('flock')->except('show');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');
        Route::get('flock/{flock}/pipes', [PipeController::class, 'indexByFlock'])->name('pipe.byFlock');
        Route::delete('/master-data/pipe/byFlock/{pipe}', [PipeController::class, 'destroyByFlock'])
            ->name('pipe.destroyByFlock');
        Route::put('/master-data/pipe/byFlock/{pipe}', [PipeController::class, 'updateByFlock'])
            ->name('pipe.updateByFlock');
        Route::put('/master-data/pipe/byFlock/{pipe}', [PipeController::class, 'updateByFlock'])
            ->name('pipe.updateByFlock');
        Route::get('ajax/kandang', [AjaxController::class, 'kandang'])->name('ajax.kandang');
        Route::get('ajax/flock/{kandangId}', [AjaxController::class, 'flock'])->name('ajax.flock');
        Route::get('ajax/pipe/{flockId}', [AjaxController::class, 'pipe'])->name('ajax.pipe');
        Route::get('ajax/umur-ayam/{pipeId}', [AjaxController::class, 'umur_ayam'])->name('ajax.umur_ayam');

        Route::get('ajax/umur-ayam-by-flock/{flockId}', [AjaxController::class, 'umurAyamByFlock'])->name('ajax.umur_ayam_by_flock');
        Route::get('ajax/kandang/{kandangId}/{tanggal}/record-populasi', [PopulasiAyamController::class, 'getRecordedPopulasi'])
            ->name('ajax.kandang.record-populasi');
        Route::get('ajax/kesehatan-ayam/{pipeId}', [AjaxController::class, 'kesehatan_ayam'])->name('ajax.kesehatan_ayam');
        Route::get('ajax/karantina-ayam/{pipeId}', [AjaxController::class, 'populasi_kandang_karantina'])->name('ajax.populasi_kandang_karantina');

        Route::get('ajax/umur-ayam-by-kandang/{kandangId}', [AjaxController::class, 'umurAyamByKandang'])->name('ajax.umur_ayam_by_kandang');
        Route::get('ajax/jumlah-ayam-sehat/{tanggal}', [AjaxController::class, 'jumlahAyamSehat'])->name('ajax.jumlah_ayam_sehat');
        Route::get('ajax/karantina-populasi/{kandangId}/{tanggal}', [AjaxController::class, 'ayamKarantina'])->name('ajax.karantina_populasi');
    });
    Route::resource('pengadaan-ayam', PengadaanAyamController::class)->names('pengadaan-ayam');
    Route::resource('populasi-ayam', PopulasiAyamController::class)->names('populasi-ayam');
    Route::get('populasi-ayam/{kandangId}/create', [PopulasiAyamController::class, 'createByDate'])
        ->name('populasi-ayam.createByDate');
    Route::resource('ayam-afkir', AyamAfkirController::class)->names('ayam-afkir');
    Route::resource('ayam-karantina', AyamKarantinaController::class)->names('ayam-karantina');
    Route::get('ayam-karantina-overview', [AyamKarantinaController::class, 'overview'])
        ->name('ayam-karantina.overview');
    Route::get('masuk-karantina', [AyamKarantinaController::class, 'masukKarantina'])
        ->name('ayam-karantina.masuk');
    Route::post('masuk-karantina', [AyamKarantinaController::class, 'storeAyamMasukKarantina'])
        ->name('ayam-karantina.masuk.store');
    Route::get('keluar-karantina', [AyamKarantinaController::class, 'keluarKarantina'])
        ->name('ayam-karantina.keluar');

    Route::resource('perhitungan-pakan', PerhitunganPakanController::class)
        ->names('perhitungan-pakan');

    Route::get('sisa-pakan', [PerhitunganPakanController::class, 'createSisaPakan'])
        ->name('sisa-pakan.create');

    Route::post('sisa-pakan', [PerhitunganPakanController::class, 'storeSisaPakan'])
        ->name('sisa-pakan.store');

    Route::get('list-data-pakan', [PerhitunganPakanController::class, 'listDataPakanHarian'])
        ->name('perhitungan-pakan.listdata');

    Route::get('list-data-sisa-pakan', [PerhitunganPakanController::class, 'listDataSisaPakanHarian'])
        ->name('sisa-pakan.listDataSisaPakanHarian');

    // sisa-pakan.delete
    Route::delete('sisa-pakan/{id}', [PerhitunganPakanController::class, 'deleteSisaPakan'])
        ->name('sisa-pakan.delete');

    Route::get('sisa-pakan/{id}/edit', [PerhitunganPakanController::class, 'editSisaPakan'])
        ->name('sisa-pakan.edit');

    Route::put('sisa-pakan/{id}', [PerhitunganPakanController::class, 'updateSisaPakan'])
        ->name('sisa-pakan.update');

    Route::get('ajax/tanggal-perhitungan-pakan',
        [AjaxController::class, 'tanggalPerhitunganPakan'])->name('ajax.tanggal-perhitungan');

    Route::get('ajax/getKandangByTanggalId/{tanggal}',
        [AjaxController::class, 'getKandangByTanggalId'])
        ->name('ajax.getKandangByTanggalId');

    Route::get('ajax/getFlockByKandangId/{kandangId}',
        [AjaxController::class, 'getFlockByKandangId'])->name('ajax.getFlockByKandangId');
    Route::get('ajax/getFlockByKandangId/{kandangId}/treatment',
        [AjaxController::class, 'getFlockByKandangTreatment'])->name('ajax.getFlockByKandangTreatment');
    Route::get('ajax/getPemberianPakanByFlockId/{tanggal}/{flock}', [AjaxController::class, 'getPemberianPakanByFlockId'])
        ->name('ajax.getPemberianPakanByFlockId');
    Route::resource('recording-telur', RecordingTelurController::class)->names('recording-telur');
    Route::resource('sampling-ayam', SamplingAyamController::class)->names('sampling-ayam');
    Route::resource('penjadwalan-disinfektan', PenjadwalanDisinfektanController::class)
        ->names('penjadwalan-disinfektan');
    Route::resource('penjadwalan-treatment', PenjadwalanTreatmentController::class)
        ->names('penjadwalan-treatment');
    Route::get('penjadwalan-disinfektan/{penjadwalanDisinfektan}/detail', [PenjadwalanDisinfektanController::class, 'getDetail'])
        ->name('penjadwalan-disinfektan.ajax-detail');
    Route::resource('ovk-pakan', OvkPakanController::class)->names('ovk-pakan');    
});
