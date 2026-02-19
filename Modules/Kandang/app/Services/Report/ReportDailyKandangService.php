<?php

namespace Modules\Kandang\Services\Report;

use Illuminate\Support\Carbon;
use Modules\Kandang\Repositories\Rekapan\RekapanPerFlockProduksiRepository;


class ReportDailyKandangService
{
    private $rekapanPerFlockProduksi;

    public function __construct(
        private RekapanPerFlockProduksiRepository $rekapanPerFlockProduksiRepository,
    ) { }

    private function getRekapanPerFlockProduksi(int $kandangId, Carbon $tanggal) 
    {
        if ($this->rekapanPerFlockProduksi) return $this->rekapanPerFlockProduksi;
        $this->rekapanPerFlockProduksi = $this->rekapanPerFlockProduksiRepository->setContext($kandangId, $tanggal)->getQuery()->get();
        return $this->rekapanPerFlockProduksi;
    }

    public function populasiAyamPerFlock(int $kandangId, Carbon $tanggal)
    {
        $datas = $this->getRekapanPerFlockProduksi($kandangId, $tanggal)->only(
            'nama_flock',
            'sehat',
            'mati',
            'afkir',
            'masuk_karantina',
            'keluar_karantina',
        );
        
        return $datas;
    }

    public function populasiAyamKandang()
    {
        
    }
}