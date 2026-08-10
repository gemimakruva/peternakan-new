<?php

namespace Modules\Kandang\Http\Controllers\PopulasiAyam;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\Kandang\KandangRepository;
use Modules\Kandang\Services\PopulasiAyamService;

class PopulasiAyamController extends Controller
{
    public function __construct(
        private PopulasiAyam $populasiAyam,
        private KandangRepository $kandangRepository,
    ) {
        $this->middleware('can:kandang.populasi.menu-populasi-ayam');
    }

    public function getRecordedPopulasi($kandangId, $tanggal)
    {
        $tanggal = Carbon::createFromFormat('Y-m-d', $tanggal);

        $datas = $this->populasiAyam
            ->whereRelation('pipe.flock', 'kandang_id', '=', $kandangId)
            ->whereDate('tanggal', '=', $tanggal)
            ->with([
                'pipe:id,nama',
                'pipe.populasiAyam' => function ($r) use($tanggal) {
                    if ($tanggal) {
                        $r->select(['ayam_sehat', 'pipe_id', 'tanggal'])->where('tanggal', '<', $tanggal)->skip(1)->orderByDesc('tanggal')->limit(1);
                    } else {
                        $r->select(['ayam_sehat', 'pipe_id', 'tanggal'])->orderByDesc('tanggal')->skip(1)->limit(1);
                    }
                },
                'pipe.pengadaanAyamDistribusi' => function ($r) {
                    $r->select(['pipe_id', 'jumlah_ayam'])->orderByDesc('id')->limit(1);
                },
                'flock:id,nama',
            ])
            ->get()
            ->map(function($item) {
                $item->ayam_sehat_before = @$item->pipe->populasiAyam[0]->ayam_sehat
                    ?? @$item->pipe->pengadaanAyamDistribusi[0]->jumlah_ayam
                    ?? 0;
                return $item;
            })
            ->toArray();

        if (!count($datas)) {
            $kandang = $this->kandangRepository
                ->getModel()
                ->with([
                    'flocks.pipes.populasiAyam' => function ($r) {
                        $r->select(['ayam_sehat', 'pipe_id', 'tanggal'])->orderByDesc('tanggal')->limit(1);
                    }
                ])
                ->findOrFail($kandangId);

            foreach ($kandang->flocks as $flock) {
                foreach ($flock->pipes as $pipe) {
                    $datas[] = [
                        'id'                        => null,
                        'flock_id'                  => $flock->id,
                        'pipe_id'                   => $pipe->id,
                        'ayam_sehat_before'         => $pipe->populasiAyam[0]->ayam_sehat ?? 0,
                        'ayam_sehat'                => 0,
                        'ayam_mati'                 => 0,
                        'ayam_afkir'                => 0,
                        'ayam_masuk_karantina'      => 0,
                        'ayam_keluar_karantina'     => 0,
                        'pipe'  => [
                            'id'    => $pipe->id,
                            'nama'  => $pipe->nama,
                        ],
                        'flock' => [
                            'id'    => $flock->id,
                            'nama'  => $flock->nama
                        ]
                    ];
                }
            }
        }

        return [
            'info'  => [
                'total_ayam_sehat_terakhir' => app(PopulasiAyamService::class)->getCurrentAyamSehatByKandang($kandangId, $tanggal),
                'total_ayam_sakit_terakhir' => app(PopulasiAyamService::class)->getLatestKarantinaPopulasi($kandangId, $tanggal),
                'umur_ayam'                 => @app(PopulasiAyamService::class)->getUmurAyamByKandangId($kandangId, $tanggal)['umur_ayam'] ?? 0,
            ],
            'items' => $datas,
        ];
    }
}
