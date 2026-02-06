<?php

namespace Modules\Kandang\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\Kandang\KandangRepository;

class KandangService
{
    private Pipe $pipe;

    private PopulasiAyam $populasiAyam;

    private PengadaanAyamDistribusi $pengadaanAyamDistribusi;

    private KarantinaPopulasi $karantinaPopulasi;

    public function __construct(private KandangRepository $repository)
    {
        $this->pipe                    = app(Pipe::class);
        $this->populasiAyam            = app(PopulasiAyam::class);
        $this->pengadaanAyamDistribusi = app(PengadaanAyamDistribusi::class);
        $this->karantinaPopulasi       = app(KarantinaPopulasi::class);
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

    public function all(): Collection
    {
        return $this->repository->all();
    }
}
