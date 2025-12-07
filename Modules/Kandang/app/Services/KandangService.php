<?php

namespace Modules\Kandang\Services;

use Illuminate\Support\Carbon;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;

class KandangService 
{
    private Pipe $pipe;
    private PopulasiAyam $populasiAyam;
    private PengadaanAyamDistribusi $pengadaanAyamDistribusi;
    private KarantinaPopulasi $karantinaPopulasi;

    public function __construct() {
        $this->pipe = app(Pipe::class);
        $this->populasiAyam = app(PopulasiAyam::class);
        $this->pengadaanAyamDistribusi = app(PengadaanAyamDistribusi::class);
        $this->karantinaPopulasi = app(KarantinaPopulasi::class);
    }

    public function getCurrentAyamSehatByPipe(int $pipeId, Carbon $tanggalPerbandingan = null)
    {
        $tanggalPerbandingan ??= now();

        $hMin1TanggalPerbandingan = $tanggalPerbandingan->clone()->subDay();

        $jumlahAyamSehatDariPengadaan = $this->pengadaanAyamDistribusi
            ->whereRelation('pengadaanAyam', function($query) use($tanggalPerbandingan, $hMin1TanggalPerbandingan) {
                $query
                    ->whereDate('tanggal', '=', $tanggalPerbandingan->format('Y-m-d'))
                    ->orWhereDate('tanggal', '=', $hMin1TanggalPerbandingan->format('Y-m-d'));
            })
            ->where('pipe_id', '=', $pipeId)
            ->value('jumlah_ayam');

        $jumlahAyamSehatDariPopulasiSebelumnya = $this->populasiAyam
            ->whereDate('tanggal', '=', $hMin1TanggalPerbandingan)
            ->where('pipe_id', '=', $pipeId)
            ->value('ayam_sehat');

        $jumlahAyamSehatTerakhir = $this->populasiAyam
            ->where('pipe_id', '=', $pipeId)
            ->latest('tanggal')
            ->value('ayam_sehat');

        $jumlahAyamSehat = $jumlahAyamSehatDariPengadaan ?? $jumlahAyamSehatDariPopulasiSebelumnya ?? $jumlahAyamSehatTerakhir ?? 0;

        return $jumlahAyamSehat;
    }

    public function getCurrentAyamKarantinaByKandang(int $asalKandangId, Carbon $tanggalPerbandingan = null)
    {
        $totalAyamKarantina = $this->karantinaPopulasi
            ->where('kandang_id', '=', $asalKandangId)
            ->when($tanggalPerbandingan, function($query, $tanggalPerbandingan) {
                $query->where('tanggal', '=', $tanggalPerbandingan->format('Y-m-d'));
            })
            ->latest('tanggal')
            ->value('total_ayam_karantina');
        
        return $totalAyamKarantina;
    }

    public function getCurrentKapasitasPipeTersedia(int $pipeId)
    {
        $kapasitas = $this->pipe->whereId($pipeId)->value('kapasitas');

        $currentAyamSehat = $this->populasiAyam
            ->getQuery()
            ->where('pipe_id', '=', $pipeId)
            ->latest('tanggal')
            ->value('ayam_sehat');

        return max([$kapasitas - $currentAyamSehat, 0]);
    }
}