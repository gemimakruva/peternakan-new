<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\AyamAfkir\AyamAfkirController;
use Modules\Kandang\Http\Controllers\AyamKarantina\AyamKarantinaController;
use Modules\Kandang\Http\Controllers\Disinfektan\PenjadwalanDisinfektanController;
use Modules\Kandang\Http\Controllers\MasterData\AjaxController;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\JenisDisinfektanController;
use Modules\Kandang\Http\Controllers\MasterData\JenisTreatmentController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\KandangFlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangFlockPipeController;
use Modules\Kandang\Http\Controllers\MasterData\MetodeTreatmentController;
use Modules\Kandang\Http\Controllers\MasterData\PeternakanController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;
use Modules\Kandang\Http\Controllers\MasterData\StrainAyamController;
use Modules\Kandang\Http\Controllers\MonitoringKesehatan\MonitoringKesehatanController;
use Modules\Kandang\Http\Controllers\OvkPakan\OrderOvkController;
use Modules\Kandang\Http\Controllers\OvkPakan\OvkPakanController;
use Modules\Kandang\Http\Controllers\PengadaanAyam\PengadaanAyamController;
use Modules\Kandang\Http\Controllers\penjadwalanTreatment\PenjadwalanTreatmentController;
use Modules\Kandang\Http\Controllers\Perhitungan_pakan\JenisPakanController;
use Modules\Kandang\Http\Controllers\Perhitungan_pakan\PerhitunganPakanController;
use Modules\Kandang\Http\Controllers\PerhitunganObat\VitaminObatMinumController;
use Modules\Kandang\Http\Controllers\PopulasiAyam\PopulasiAyamController;
use Modules\Kandang\Http\Controllers\RecordingTelur\RecordingTelurController;
use Modules\Kandang\Http\Controllers\SamplingAyam\SamplingAyamController;
use Modules\Kandang\Http\Controllers\VaksinMinum\VaksinMinumController;

Route::middleware(['auth'])->group(function () {

    // ===== Menu Group Master Data =====
    Route::prefix('master-data')->as('master-data.')->group(function () {
        Route::resource('peternakan', PeternakanController::class)->names('peternakan');
        
        Route::get('strain-ayam', [StrainAyamController::class, 'index'])->name('strain-ayam.index');

        Route::resource('jenis-pakan', JenisPakanController::class)->names('jenis-pakan')->except('show');
        Route::resource('jenis-disinfektan', JenisDisinfektanController::class)->names('jenis-disinfektan');
        Route::resource('jenis-treatment', JenisTreatmentController::class)->names('jenis-treatment');
        Route::resource('metode-treatment', MetodeTreatmentController::class)->names('metode-treatment');

        Route::resource('kandang', KandangController::class)->names('kandang');
        Route::resource('kandang.flock', KandangFlockController::class)->names('kandang.flock')->except('index');
        Route::resource('kandang.flock.pipe', KandangFlockPipeController::class)->names('kandang.flock.pipe')->except('index');
        Route::resource('flock', FlockController::class)->names('flock');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');

        Route::get('ajax/kandang', [AjaxController::class, 'kandang'])->name('ajax.kandang');
        Route::get('ajax/flock/{kandangId}', [AjaxController::class, 'flock'])->name('ajax.flock');
        Route::get('ajax/pipe/{flockId}', [AjaxController::class, 'pipe'])->name('ajax.pipe');
        Route::get('ajax/umur-ayam/{pipeId}', [AjaxController::class, 'umur_ayam'])->name('ajax.umur_ayam');

        Route::get('ajax/umur-ayam-by-flock/{flockId}', [AjaxController::class, 'umurAyamByFlock'])->name('ajax.umur_ayam_by_flock');
        Route::get('ajax/kandang/{kandangId}/{tanggal}/record-populasi', [PopulasiAyamController::class, 'getRecordedPopulasi'])->name('ajax.kandang.record-populasi');
        Route::get('ajax/kesehatan-ayam/{pipeId}', [AjaxController::class, 'kesehatan_ayam'])->name('ajax.kesehatan_ayam');
        Route::get('ajax/karantina-ayam/{pipeId}', [AjaxController::class, 'populasi_kandang_karantina'])->name('ajax.populasi_kandang_karantina');

        Route::get('ajax/umur-ayam-by-kandang/{kandangId}', [AjaxController::class, 'umurAyamByKandang'])->name('ajax.umur_ayam_by_kandang');
        Route::get('ajax/jumlah-ayam-sehat/{tanggal}', [AjaxController::class, 'jumlahAyamSehat'])->name('ajax.jumlah_ayam_sehat');
        Route::get('ajax/karantina-populasi/{kandangId}/{tanggal}', [AjaxController::class, 'ayamKarantina'])->name('ajax.karantina_populasi');
        Route::get('ajax/jumlah-ayam-per-kandang', [AjaxController::class, 'getJumlahAyamPerKandang'])->name('ajax.jumlah_ayam_per_kandang');
    });

    Route::resource('vaksin-minum', VaksinMinumController::class)->names('vaksin-minum');

    // ===== Menu Group Pengadaan Ayam =====
    Route::resource('pengadaan-ayam', PengadaanAyamController::class)->names('pengadaan-ayam');

    // ===== Menu Group Populasi Ayam =====
    Route::get('populasi-ayam/summary', [PopulasiAyamController::class, 'getSummary'])->name('populasi-ayam.summary');
    Route::resource('populasi-ayam', PopulasiAyamController::class)->parameter('populasi-ayam', 'kandang')->names('populasi-ayam')->only(['index', 'store']);
    Route::resource('populasi-ayam', PopulasiAyamController::class)->names('populasi-ayam')->only(['edit', 'update']);
    Route::get('populasi-ayam/{kandang}/create', [PopulasiAyamController::class, 'create'])->name('populasi-ayam.create');
    Route::get('populasi-ayam/{kandang}/flock', [PopulasiAyamController::class, 'flockIndex'])->name('populasi-ayam.flock.index');
    Route::get('populasi-ayam/{kandang}/flock/{flock}/pipe', [PopulasiAyamController::class, 'flockPipeIndex'])->name('populasi-ayam.flock.pipe.index');

    // ===== Menu Group Ayam Afkir =====
    Route::resource('ayam-afkir', AyamAfkirController::class)->names('ayam-afkir')->except(['create', 'show', 'store', 'destroy']);

    // ===== Menu Group Ayam Karantina =====
    Route::resource('ayam-karantina', AyamKarantinaController::class)->parameter('ayam-karantina', 'karantina-populasi')->names('ayam-karantina')->only(['index', 'edit', 'update']);
    Route::get('ayam-karantina-overview', [AyamKarantinaController::class, 'overview'])->name('ayam-karantina.overview');

    // ===== Menu Group Pemberian Pakan ====
    Route::resource('perhitungan-pakan', PerhitunganPakanController::class)->names('perhitungan-pakan');

    Route::get('sisa-pakan', [PerhitunganPakanController::class, 'createSisaPakan'])->name('sisa-pakan.create');
    Route::post('sisa-pakan', [PerhitunganPakanController::class, 'storeSisaPakan'])->name('sisa-pakan.store');
    Route::delete('sisa-pakan/{id}', [PerhitunganPakanController::class, 'deleteSisaPakan'])->name('sisa-pakan.delete');
    Route::get('sisa-pakan/{id}/edit', [PerhitunganPakanController::class, 'editSisaPakan'])->name('sisa-pakan.edit');
    Route::put('sisa-pakan/{id}', [PerhitunganPakanController::class, 'updateSisaPakan'])->name('sisa-pakan.update');

    Route::get('list-data-pakan', [PerhitunganPakanController::class, 'listDataPakanHarian'])->name('perhitungan-pakan.listdata');
    Route::get('list-data-sisa-pakan', [PerhitunganPakanController::class, 'listDataSisaPakanHarian'])->name('sisa-pakan.listDataSisaPakanHarian');


    Route::get('ajax/tanggal-perhitungan-pakan', [AjaxController::class, 'tanggalPerhitunganPakan'])->name('ajax.tanggal-perhitungan');
    Route::get('ajax/getKandangByTanggalId/{tanggal}', [AjaxController::class, 'getKandangByTanggalId'])->name('ajax.getKandangByTanggalId');
    Route::get('ajax/getFlockByKandangId/{kandangId}', [AjaxController::class, 'getFlockByKandangId'])->name('ajax.getFlockByKandangId');
    Route::get('ajax/getFlockByKandangId/{kandangId}/treatment',[AjaxController::class, 'getFlockByKandangTreatment'])->name('ajax.getFlockByKandangTreatment');

    Route::get('ajax/getPemberianPakanByFlockId/{tanggal}/{flock}', [AjaxController::class, 'getPemberianPakanByFlockId'])->name('ajax.getPemberianPakanByFlockId');
    Route::resource('recording-telur', RecordingTelurController::class)->names('recording-telur');
    Route::resource('sampling-ayam', SamplingAyamController::class)->names('sampling-ayam');
    
    Route::resource('penjadwalan-disinfektan', PenjadwalanDisinfektanController::class)->names('penjadwalan-disinfektan');
    Route::resource('penjadwalan-treatment', PenjadwalanTreatmentController::class)->names('penjadwalan-treatment');
    Route::get('penjadwalan-disinfektan/{penjadwalanDisinfektan}/detail', [PenjadwalanDisinfektanController::class, 'getDetail'])->name('penjadwalan-disinfektan.ajax-detail');
    Route::resource('ovk-pakan', OvkPakanController::class)->names('ovk-pakan');
    Route::resource('orders-ovk', OrderOvkController::class)->names('order-ovk');
    Route::group(['prefix' => 'perhitungan-obat', 'as' => 'perhitungan-obat.'], function () {
        Route::resource('vitamin-obat-minum', VitaminObatMinumController::class)->names('vitamin-obat-minum');
    });
    Route::resource('monitoring-kesehatan', MonitoringKesehatanController::class)->names('monitoring-kesehatan');
});
