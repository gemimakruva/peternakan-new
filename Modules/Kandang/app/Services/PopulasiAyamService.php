<?php

namespace Modules\Kandang\Services;

use Illuminate\Http\Request;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\AyamAfkirPopulasi;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\KarantinaPopulasiPipe;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\PopulasiAyamRepository;
use Modules\Kandang\Services\Contracts\PopulasiAyamServiceInterface;

class PopulasiAyamService implements PopulasiAyamServiceInterface
{
    public function __construct(
        private PopulasiAyamRepository $populasiAyamRepository,
        private AyamAfkir $ayamAfkir,
        private AyamAfkirPopulasi $ayamAfkirPopulasi,
        private KarantinaPopulasi $karantinaPopulasi,
        private KarantinaPopulasiPipe $karantinaPopulasiPipe,
    ) {}

    public function getChickensPerRow(array $filter): array
    {
        $total = $this->populasiAyamRepository->getChickensPerRow($filter['flock_id'], $filter['date']);

        return [
            'flock_id' => $filter['flock_id'],
            'date'     => $filter['date'],
            'total'    => $total,
        ];
    }

    public function savePopulasiAyam(Request $request): PopulasiAyam
    {
        $populasiAyam = $this->populasiAyamRepository->getModel()->updateOrCreate([
            'pic_user_id'           => auth()->id(),
            'pipe_id'               => $request->input('pipe_id'),
            'jenis_pemeriksaan'     => JenisPemeriksaan::HARIAN,
            'tanggal'               => $request->input('tanggal_transaksi', 0),
        ], [
            'umur_ayam_record'      => $request->integer('umur_ayam_record', 0),
            'ayam_sehat'            => $request->integer('ayam_sehat', 0),
            'ayam_mati'             => $request->integer('ayam_mati', 0),
            'ayam_afkir'            => $request->integer('ayam_afkir', 0),
            'ayam_masuk_karantina'  => $request->integer('ayam_masuk_karantina', 0),
            'ayam_keluar_karantina' => $request->integer('ayam_keluar_karantina', 0),
            'catatan'               => $request->input('catatan', null),
        ]);

        $this->saveAyamAfkir($populasiAyam);
        $this->saveAyamKarantina($populasiAyam);

        return $populasiAyam;
    }

    public function saveAyamAfkir(PopulasiAyam $populasiAyam)
    {
        $populasiAyam->load([
            'pipe:id,flock_id',
            'pipe.flock:id,kandang_id',
        ]);

        if ($populasiAyam->ayam_afkir > 0) {
            $ayamAfkir = $this->ayamAfkir->firstOrCreate([
                'kandang_id'        => $populasiAyam->pipe->flock->kandang_id,
                'tanggal'           => $populasiAyam->tanggal,
                'umur_ayam'         => $populasiAyam->umur_ayam_record,
            ]);

            $this->ayamAfkirPopulasi->updateOrCreate([
                'populasi_ayam_id'  => $populasiAyam->id,
            ], [
                'ayam_afkir_id'     => $ayamAfkir->id,
                'pipe_id'           => $populasiAyam->pipe->id,
                'flock_id'          => $populasiAyam->pipe->flock->id,
                'kandang_id'        => $populasiAyam->pipe->flock->kandang_id,
                'pic_user_id'       => $populasiAyam->pic_user_id,
                'tanggal'           => $populasiAyam->tanggal,
                'jumlah_ayam_afkir' => $populasiAyam->ayam_afkir
            ]);
        } else {
            $this->ayamAfkir->where('populasi_ayam_id', '=', $populasiAyam->id)->delete();
        }
    }

    public function saveAyamKarantina(PopulasiAyam $populasiAyam)
    {
        // get kandangId
        $kandangId = $populasiAyam->pipe->flock->kandang_id;

        // save ayam masuk karantina
        if (@$populasiAyam->ayam_masuk_karantina) {
            $kpp = $this->karantinaPopulasiPipe->updateOrCreate([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'pipe_asal_id'          => $populasiAyam->pipe_id,
            ], [
                'ayam_masuk_karantina'  => $populasiAyam->ayam_masuk_karantina,
            ]);
            if (app()->runningInConsole()) {
                echo "$kpp->id, kandang $kandangId - karantina ayam masuk sebanyak $populasiAyam->ayam_masuk_karantina ke pipe $populasiAyam->pipe_id" . PHP_EOL;
            }
        } else {
            $this->karantinaPopulasiPipe->where([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'pipe_asal_id'          => $populasiAyam->pipe_id,
            ])->delete();
        }

        // save ayam keluar karantina
        if (@$populasiAyam->ayam_keluar_karantina) {
            $kpp = $this->karantinaPopulasiPipe->updateOrCreate([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'pipe_tujuan_id'        => $populasiAyam->pipe_id,
            ], [
                'ayam_keluar_karantina' => $populasiAyam->ayam_keluar_karantina,
            ]);
            if (app()->runningInConsole()) {
                echo "$kpp->id, kandang $kandangId - karantina ayam keluar sebanyak $populasiAyam->ayam_keluar_karantina ke pipe $populasiAyam->pipe_id" . PHP_EOL;
            }
        } else {
            $this->karantinaPopulasiPipe->where([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'pipe_tujuan_id'        => $populasiAyam->pipe_id,
            ])->delete();
        }

        $currentKarantinaPopulasi = $this->getLatestKarantinaPopulasi($kandangId, $populasiAyam->tanggal);

        // save karantina populasi
        if ($currentKarantinaPopulasi > 0) {
            $this->karantinaPopulasi->updateOrCreate([
                'kandang_id' => $kandangId,
                'tanggal'    => $populasiAyam->tanggal,
            ], [
                'pic_user_id'          => $populasiAyam->pic_user_id,
                'total_ayam_karantina' => $currentKarantinaPopulasi,
            ]);
        } else {
            $this->karantinaPopulasi->where([
                'kandang_id' => $kandangId,
                'tanggal'    => $populasiAyam->tanggal,
            ])->delete();
        }

        if (app()->runningInConsole() && $currentKarantinaPopulasi > 0) {
            echo "kandang $kandangId - karantina populasi sebanyak $currentKarantinaPopulasi - $populasiAyam->tanggal" . PHP_EOL;
        }
    }

    public function getLatestKarantinaPopulasi($kandangId, $tanggal)
    {
        // ambil total ayam karantina, terakhir hari kemarin
        $latestTotalAyamKarantina = (int) $this->karantinaPopulasi
            ->query()
            ->where('kandang_id', '=', $kandangId)
            ->whereDate('tanggal', '<', $tanggal)
            ->orderByDesc('tanggal')
            ->limit(1)
            ->value('total_ayam_karantina') ?? 0;
        
        // update populasi karantina berdasarkan ayam masuk/keluar
        $totalAyamMasukKarantina = $this->karantinaPopulasiPipe
            ->query()
            ->from('karantina_populasi_pipe', 'kpp')
            ->join('pipe AS p', function($query) {
                $query
                    ->on('p.id', '=', 'kpp.pipe_asal_id')
                    ->orOn('p.id', '=', 'kpp.pipe_tujuan_id');
            })
            ->join('flock AS f', 'f.id', '=', 'p.flock_id')
            ->where('f.kandang_id', '=', $kandangId)
            ->where('kpp.tanggal', '=', $tanggal)
            ->groupBy('f.kandang_id')
            ->selectRaw('(coalesce(sum(kpp.ayam_masuk_karantina),0) - coalesce(sum(kpp.ayam_keluar_karantina),0)) AS total_ayam_karantina')
            ->value('total_ayam_karantina') ?? 0;

        $currentKarantinaPopulasi = $latestTotalAyamKarantina + $totalAyamMasukKarantina;

        return $currentKarantinaPopulasi;
    }
}
