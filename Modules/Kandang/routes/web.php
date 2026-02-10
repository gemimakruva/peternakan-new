<?php

use Illuminate\Support\Facades\Route;
use Modules\Kandang\Http\Controllers\AyamAfkir\AyamAfkirController;
use Modules\Kandang\Http\Controllers\AyamKarantina\AyamKarantinaController;
use Modules\Kandang\Http\Controllers\MasterData\AjaxController;
use Modules\Kandang\Http\Controllers\MasterData\FlockController;
use Modules\Kandang\Http\Controllers\MasterData\JenisTreatmentController;
use Modules\Kandang\Http\Controllers\MasterData\KandangController;
use Modules\Kandang\Http\Controllers\MasterData\KandangFlockController;
use Modules\Kandang\Http\Controllers\MasterData\KandangFlockPipeController;
use Modules\Kandang\Http\Controllers\MasterData\MetodeTreatmentController;
use Modules\Kandang\Http\Controllers\MasterData\PeternakanController;
use Modules\Kandang\Http\Controllers\MasterData\PipeController;
use Modules\Kandang\Http\Controllers\MasterData\StrainAyamController;
use Modules\Kandang\Http\Controllers\MonitoringKesehatan\MonitoringKesehatanController;
use Modules\Kandang\Http\Controllers\PengadaanAyam\PengadaanAyamController;
use Modules\Kandang\Http\Controllers\PerhitunganPakan\JenisPakanController;
use Modules\Kandang\Http\Controllers\PerhitunganPakan\OverviewPakanHarianController;
use Modules\Kandang\Http\Controllers\PerhitunganPakan\PemberianPakanSisaPakanController;
use Modules\Kandang\Http\Controllers\PerhitunganPakan\PerhitunganPakanController;
use Modules\Kandang\Http\Controllers\PopulasiAyam\PopulasiAyamController;
use Modules\Kandang\Http\Controllers\RecordingTelur\OverviewProduksiTelurController;
use Modules\Kandang\Http\Controllers\RecordingTelur\RecordingTelurController;
use Modules\Kandang\Http\Controllers\Rekapan\ProduksiController;
use Modules\Kandang\Http\Controllers\SamplingAyam\SamplingAyamController;
use Modules\Kandang\Http\Controllers\Treatment\TreatmentController;
use Modules\Kandang\Http\Controllers\Treatment\TreatmentPelaksanaanController;
use Modules\Kandang\Http\Controllers\VaksinMinum\VaksinMinumController;

Route::middleware(['auth'])->group(function () {

    // ===== Menu Group Master Data =====
    Route::prefix('master-data')->as('master-data.')->group(function () {
        Route::resource('peternakan', PeternakanController::class)->names('peternakan');
        
        Route::get('strain-ayam', [StrainAyamController::class, 'index'])->name('strain-ayam.index');

        Route::resource('jenis-pakan', JenisPakanController::class)->names('jenis-pakan')->except('show');
        Route::resource('jenis-treatment', JenisTreatmentController::class)->names('jenis-treatment');
        Route::resource('metode-treatment', MetodeTreatmentController::class)->names('metode-treatment');

        Route::resource('kandang', KandangController::class)->names('kandang');
        Route::resource('kandang.flock', KandangFlockController::class)->names('kandang.flock')->except('index');
        Route::resource('kandang.flock.pipe', KandangFlockPipeController::class)->names('kandang.flock.pipe')->except('index');
        Route::resource('flock', FlockController::class)->names('flock');
        Route::resource('pipe', PipeController::class)->names('pipe')->except('show');
    });

    // ===== Ajax Start =====
    Route::get('ajax/kandang', [AjaxController::class, 'kandang'])->name('ajax.kandang');
    Route::get('ajax/flock/{kandangId}', [AjaxController::class, 'flock'])->name('ajax.flock');
    Route::get('ajax/pipe/{flockId}', [AjaxController::class, 'pipe'])->name('ajax.pipe');

    Route::get('ajax/umur-ayam-by-pipe/{pipeId}', [AjaxController::class, 'umurAyamByPipe'])->name('ajax.umur_ayam_by_pipe');
    Route::get('ajax/umur-ayam-by-flock/{flockId}', [AjaxController::class, 'umurAyamByFlock'])->name('ajax.umur_ayam_by_flock');
    Route::get('ajax/umur-ayam-by-kandang/{kandangId}', [AjaxController::class, 'umurAyamByKandang'])->name('ajax.umur_ayam_by_kandang');

    Route::get('ajax/kandang/{kandangId}/record-populasi/{tanggal}', [PopulasiAyamController::class, 'getRecordedPopulasi'])->name('ajax.kandang.record-populasi');

    Route::get('ajax/pipe/{pipeId}/populasi/{tanggal}', [AjaxController::class, 'populasiByPipe'])
        ->whereNumber('pipeId')
        ->where('tanggal', '\d{4}-\d{2}-\d{2}')    
        ->name('ajax.populasi-by-pipe');
    Route::get('ajax/flock/{flockId}/populasi/{tanggal}', [AjaxController::class, 'populasiByFlock'])
        ->whereNumber('flockId')
        ->where('tanggal', '\d{4}-\d{2}-\d{2}')
        ->name('ajax.populasi-by-flock');
    Route::get('ajax/kandang/{kandangId}/populasi/{tanggal}', [AjaxController::class, 'populasiByKandang'])
        ->whereNumber('kandangId')
        ->where('tanggal', '\d{4}-\d{2}-\d{2}')
        ->name('ajax.populasi-by-kandang');

    Route::get('ajax/karantina/{kandangId}/populasi/{tanggal}', [AjaxController::class, 'ayamKarantina'])->name('ajax.karantina_populasi');
    // ===== Ajax End =====

    // ===== Menu Group Pengadaan Ayam =====
    Route::resource('pengadaan-ayam', PengadaanAyamController::class)->names('pengadaan-ayam');

    // ===== Menu Group Populasi Ayam =====
    Route::resource('populasi-ayam', PopulasiAyamController::class)->parameter('populasi-ayam', 'kandang')->names('populasi-ayam')->only(['index', 'store']);
    Route::resource('populasi-ayam', PopulasiAyamController::class)->names('populasi-ayam')->only(['edit', 'update']);
    Route::get('populasi-ayam/{kandang}/create', [PopulasiAyamController::class, 'create'])->name('populasi-ayam.create');
    Route::get('populasi-ayam/{kandang}/flock', [PopulasiAyamController::class, 'flockIndex'])->name('populasi-ayam.flock.index');
    Route::get('populasi-ayam/{kandang}/flock/{flock}/pipe', [PopulasiAyamController::class, 'flockPipeIndex'])->name('populasi-ayam.flock.pipe.index');

    // ===== Menu Group Ayam Afkir =====
    Route::resource('ayam-afkir', AyamAfkirController::class)->names('ayam-afkir')->except(['create', 'show', 'store', 'destroy']);

    // ===== Menu Group Ayam Karantina =====
    Route::resource('ayam-karantina', AyamKarantinaController::class)->parameter('ayam-karantina', 'karantina-populasi')->names('ayam-karantina')->only(['index', 'edit', 'update', 'create', 'store']);
    Route::get('ayam-karantina-overview', [AyamKarantinaController::class, 'overview'])->name('ayam-karantina.overview');

    // ===== Menu Group Pemberian Pakan ====
    Route::resource('perhitungan-pakan', PerhitunganPakanController::class)
        ->names('perhitungan-pakan')
        ->except('show', 'destroy');
    Route::resource('pemberian-pakan-sisa-pakan', PemberianPakanSisaPakanController::class)->names('pemberian-pakan-sisa-pakan')
        ->parameters(['pemberian-pakan-sisa-pakan' => 'perhitungan-pakan'])
        ->except('create', 'show', 'update', 'destroy');
    Route::get('overview-pakan-harian', [OverviewPakanHarianController::class, 'index'])->name('overview-pakan-harian');

    // ===== Menu Rekapan =====
    Route::get('rekapan-produksi', [ProduksiController::class, 'index'])->name('rekapan-produksi.index');

    // ===== Menu Produksi Telur =====
    Route::resource('recording-telur', RecordingTelurController::class)->names('recording-telur');
    Route::get('overview-produksi-telur', [OverviewProduksiTelurController::class, 'index'])->name('overview-produksi-telur');

    Route::resource('sampling-ayam', SamplingAyamController::class)->names('sampling-ayam');

    Route::resource('treatment', TreatmentController::class)->names('treatment')->except('show');
    Route::get('treatment-pelaksanaan', [TreatmentPelaksanaanController::class, 'index'])->name('treatment-pelaksanaan.index');
    Route::get('treatment-pelaksanaan/{kandangId}/{bulan}/jadwal', [TreatmentPelaksanaanController::class, 'jadwal'])->name('treatment-pelaksanaan.jadwal');
    Route::get('treatment-pelaksanaan/{kandangId}/{bulan}/jadwal/{treatmentJadwalId}/pelaksanaan', [TreatmentPelaksanaanController::class, 'pelaksanaan'])->name('treatment-pelaksanaan.jadwal.pelaksanaan');
    Route::post('treatment-pelaksanaan/{kandangId}/{bulan}/jadwal/{treatmentJadwalId}/pelaksanaan', [TreatmentPelaksanaanController::class, 'pelaksanaanStore'])->name('treatment-pelaksanaan.jadwal.pelaksanaan.store');

    Route::resource('monitoring-kesehatan', MonitoringKesehatanController::class)->names('monitoring-kesehatan');
});
