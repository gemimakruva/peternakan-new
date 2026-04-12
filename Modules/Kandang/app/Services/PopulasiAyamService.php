<?php

namespace Modules\Kandang\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Enums\JenisPemeriksaan;
use Modules\Kandang\Models\AyamAfkir;
use Modules\Kandang\Models\AyamAfkirPopulasi;
use Modules\Kandang\Models\AyamPindah;
use Modules\Kandang\Models\KarantinaPopulasi;
use Modules\Kandang\Models\KarantinaPopulasiPipe;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\PopulasiAyamRepository;

class PopulasiAyamService
{
    public function __construct(
        private PopulasiAyamRepository $populasiAyamRepository,
        private AyamAfkir $ayamAfkir,
        private AyamAfkirPopulasi $ayamAfkirPopulasi,
        private KarantinaPopulasi $karantinaPopulasi,
        private KarantinaPopulasiPipe $karantinaPopulasiPipe,
        private PengadaanAyamDistribusi $pengadaanAyamDistribusi,
        private AyamPindah $ayamPindah,
    ) {}

    public function getPerkiraanBobotAyamKandang($kandangId, ?Carbon $tanggal)
    {
        return DB::table('sampling_bobot_ayam_per_ekor as sbape')
            ->join('sampling_bobot_ayam as sba', 'sba.id', '=', 'sbape.sampling_bobot_ayam_id')
            ->selectRaw(<<<'SQL'
                sum(sbape.bobot_per_kg)/count(sbape.bobot_per_kg)*sba.jumlah_ayam_saat_ini as bobot_ayam_keseluruhan
                , sum(sbape.bobot_per_kg)/count(sbape.bobot_per_kg) as bobot_ayam_rata2
                , sba.jumlah_ayam_saat_ini
            SQL)
            ->where('sba.kandang_id', '=', $kandangId)
            ->where('sba.tanggal', '<=', $tanggal)
            ->groupBy('sbape.sampling_bobot_ayam_id')
            ->orderByDesc('sba.tanggal')
            ->first();
    }

    public function getCurrentAyamSehatByPipe(int $pipeId, ?Carbon $tanggalPerbandingan = null)
    {
        $tanggalPerbandingan ??= now();

        $hMin1TanggalPerbandingan = $tanggalPerbandingan->clone()->subDay();

        $jumlahAyamSehatHariIni = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $tanggalPerbandingan)
            ->where('pipe_id', '=', $pipeId)
            ->value('ayam_sehat');

        if ($jumlahAyamSehatHariIni > 0) {
            return (int) $jumlahAyamSehatHariIni;
        }

        $jumlahAyamSehatDariPopulasiSebelumnya = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $hMin1TanggalPerbandingan)
            ->where('pipe_id', '=', $pipeId)
            ->value('ayam_sehat');

        if ($jumlahAyamSehatDariPopulasiSebelumnya > 0) {
            return (int) $jumlahAyamSehatDariPopulasiSebelumnya;
        }

        $jumlahAyamSehatTerakhir = $this->populasiAyamRepository->getModel()
            ->where('pipe_id', '=', $pipeId)
            ->latest('tanggal')
            ->value('ayam_sehat');

        if ($jumlahAyamSehatTerakhir > 0) {
            return (int) $jumlahAyamSehatTerakhir;
        }

        return 0;
    }

    public function getCurrentAyamSehatByFlock(int $flockId, ?Carbon $tanggalPerbandingan = null)
    {
        $tanggalPerbandingan ??= now();

        $hMin1TanggalPerbandingan = $tanggalPerbandingan->clone()->subDay();

        $jumlahAyamSehatHariIni = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $tanggalPerbandingan)
            ->where('flock_id', '=', $flockId)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatHariIni > 0) {
            return (int) $jumlahAyamSehatHariIni;
        }

        $jumlahAyamSehatDariPopulasiSebelumnya = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $hMin1TanggalPerbandingan)
            ->where('flock_id', '=', $flockId)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatDariPopulasiSebelumnya > 0) {
            return (int) $jumlahAyamSehatDariPopulasiSebelumnya;
        }

        $tanggalTerakhir = $this->populasiAyamRepository->getModel()
            ->where('flock_id', $flockId)
            ->max('tanggal');

        $jumlahAyamSehatTerakhir = $this->populasiAyamRepository->getModel()
            ->where('flock_id', '=', $flockId)
            ->where('tanggal', $tanggalTerakhir)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatTerakhir > 0) {
            return (int) $jumlahAyamSehatTerakhir;
        }

        return 0;
    }

    public function getCurrentAyamSehatByKandang(int $kandangId, ?Carbon $tanggalPerbandingan = null)
    {
        $tanggalPerbandingan ??= now();

        $hMin1TanggalPerbandingan = $tanggalPerbandingan->clone()->subDay();

        $jumlahAyamSehatHariIni = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $tanggalPerbandingan)
            ->where('kandang_id', '=', $kandangId)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatHariIni > 0) {
            return (int) $jumlahAyamSehatHariIni;
        }

        $jumlahAyamSehatDariPopulasiSebelumnya = $this->populasiAyamRepository->getModel()
            ->whereDate('tanggal', '=', $hMin1TanggalPerbandingan)
            ->where('kandang_id', '=', $kandangId)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatDariPopulasiSebelumnya > 0) {
            return (int) $jumlahAyamSehatDariPopulasiSebelumnya;
        }

        $tanggalTerakhir = $this->populasiAyamRepository->getModel()
            ->where('kandang_id', $kandangId)
            ->max('tanggal');

        $jumlahAyamSehatTerakhir = $this->populasiAyamRepository->getModel()
            ->where('kandang_id', $kandangId)
            ->where('tanggal', $tanggalTerakhir)
            ->sum('ayam_sehat');

        if ($jumlahAyamSehatTerakhir > 0) {
            return (int) $jumlahAyamSehatTerakhir;
        }

        return 0;
    }

    public function getUmurAyamByPipeId($pipeId, Carbon $tanggalPembanding): ?array
    {
        $data = app(PengadaanAyamDistribusi::class)
            ->join('pengadaan_ayam', 'pengadaan_ayam.id', '=', 'pengadaan_ayam_distribusi.pengadaan_ayam_id')
            ->where('pengadaan_ayam_distribusi.pipe_id', $pipeId)
            ->orderByDesc('pengadaan_ayam.tanggal')
            ->orderByDesc('pengadaan_ayam_distribusi.id')
            ->firstOrFail([
                'pengadaan_ayam.tanggal',
                'pengadaan_ayam.umur_ayam',
                'pengadaan_ayam.penyesuaian_hari_umur_ayam',
            ]);

        return $this->getUmurAyamResponse($data, $tanggalPembanding);
    }

    public function getUmurAyamByFlockId($flockId, Carbon $tanggalPembanding): ?array
    {
        $data = app(PengadaanAyamDistribusi::class)
            ->join('pengadaan_ayam', 'pengadaan_ayam.id', '=', 'pengadaan_ayam_distribusi.pengadaan_ayam_id')
            ->where('pengadaan_ayam_distribusi.flock_id', $flockId)
            ->orderByDesc('pengadaan_ayam.tanggal')
            ->orderByDesc('pengadaan_ayam_distribusi.id')
            ->firstOrFail([
                'pengadaan_ayam.tanggal',
                'pengadaan_ayam.umur_ayam',
                'pengadaan_ayam.penyesuaian_hari_umur_ayam',
            ]);

        return $this->getUmurAyamResponse($data, $tanggalPembanding);
    }

    public function getUmurAyamByKandangId($kandangId, Carbon $tanggalPembanding): ?array
    {
        $data = app(PengadaanAyamDistribusi::class)
            ->join('pengadaan_ayam', 'pengadaan_ayam.id', '=', 'pengadaan_ayam_distribusi.pengadaan_ayam_id')
            ->where('pengadaan_ayam_distribusi.kandang_id', $kandangId)
            ->orderByDesc('pengadaan_ayam.tanggal')
            ->orderByDesc('pengadaan_ayam_distribusi.id')
            ->firstOrFail([
                'pengadaan_ayam.tanggal',
                'pengadaan_ayam.umur_ayam',
                'pengadaan_ayam.penyesuaian_hari_umur_ayam',
            ]);

        return $this->getUmurAyamResponse($data, $tanggalPembanding);
    }

    private function getUmurAyamResponse(PengadaanAyamDistribusi $data, Carbon $tanggalPembanding)
    {
        // Validasi apakah tanggal pengadaan ada
        if (! $data->tanggal || ! $data->umur_ayam) {
            return;
        }

        // Adjust umur ayam dengan hari
        $tanggalPembanding->addDays($data->penyesuaian_hari_umur_ayam);

        // Hitung umur ayam dalam minggu
        $tanggalPengadaan           = Carbon::parse($data->tanggal)->startOfDay();
        $usiaAyamSaatPengadaan      = $data->umur_ayam; // dalam minggu
        $selisihHariDariPengadaan   = $tanggalPengadaan->diffInDays($tanggalPembanding);
        $selisihMingguDariPengadaan = floor($selisihHariDariPengadaan / 7);

        $usiaAyamSaatIni = $usiaAyamSaatPengadaan + $selisihMingguDariPengadaan;

        return [
            'umur_ayam'                     => $usiaAyamSaatIni,
            'umur_ayam_saat_pengadaan'      => $usiaAyamSaatPengadaan,
            'selisih_minggu_dari_pengadaan' => $selisihMingguDariPengadaan,
            'tanggal_pengadaan'             => $tanggalPengadaan->format('Y-m-d'),
            'tanggal_pembanding'            => $tanggalPembanding->format('Y-m-d'),
        ];
    }

    public function savePopulasiAyam(Request $request): PopulasiAyam
    {
        $populasiAyam = $this->populasiAyamRepository->getModel()->updateOrCreate([
            'pic_user_id'           => auth()->id(),
            'kandang_id'            => $request->input('kandang_id'),
            'flock_id'              => $request->input('flock_id'),
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

    public function deletePopulasiAyam2($kandangId, $tanggal)
    {
        $karantina = $this->karantinaPopulasi
            ->where('kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->first();
        if ($karantina) {
            $karantina->karantinaPopulasiPipes()->delete();
            $karantina->delete();
        }

        $afkir = $this->ayamAfkir
            ->where('kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->first();
        if ($afkir) {
            $afkir->ayamAfkirPopulasi()->delete();
            $afkir->delete();
        }

        $this->populasiAyamRepository
            ->getModel()
            ->where('kandang_id', '=', $kandangId)
            ->where('tanggal', '=', $tanggal)
            ->delete();
    }

    public function savePopulasiAyam2(Collection $datas): Collection
    {
        $listPopulasiAyam = [];

        foreach ($datas as $data) {
            $populasiAyam = $this->populasiAyamRepository->getModel()->updateOrCreate([
                'pic_user_id'           => auth()->id(),
                'kandang_id'            => $data['kandang_id'],
                'flock_id'              => $data['flock_id'],
                'pipe_id'               => $data['pipe_id'],
                'tanggal'               => $data['tanggal'],
            ], [
                'umur_ayam_record'      => $data['umur_ayam'],
                'ayam_sehat'            => $data['ayam_sehat'],
                'ayam_mati'             => $data['ayam_mati'],
                'ayam_afkir'            => $data['ayam_afkir'],
                'ayam_masuk_karantina'  => $data['ayam_masuk_karantina'],
                'ayam_keluar_karantina' => $data['ayam_keluar_karantina'],
                'catatan'               => @$data['catatan'] ?? null,
            ]);

            $this->saveAyamAfkir($populasiAyam);
            $this->saveAyamKarantina($populasiAyam);

            $listPopulasiAyam[] = $populasiAyam;
        }

        return collect($listPopulasiAyam);
    }

    public function saveAyamAfkir(PopulasiAyam $populasiAyam)
    {
        if ($populasiAyam->ayam_afkir > 0) {
            $ayamAfkir = $this->ayamAfkir->firstOrCreate([
                'kandang_id'        => $populasiAyam->kandang_id,
                'tanggal'           => $populasiAyam->tanggal,
                'umur_ayam'         => $populasiAyam->umur_ayam_record,
            ]);

            $this->ayamAfkirPopulasi->updateOrCreate([
                'populasi_ayam_id'  => $populasiAyam->id,
            ], [
                'ayam_afkir_id'     => $ayamAfkir->id,
                'pipe_id'           => $populasiAyam->pipe_id,
                'flock_id'          => $populasiAyam->flock_id,
                'kandang_id'        => $populasiAyam->kandang_id,
                'pic_user_id'       => $populasiAyam->pic_user_id,
                'tanggal'           => $populasiAyam->tanggal,
                'jumlah_ayam_afkir' => $populasiAyam->ayam_afkir,
            ]);
        } else {
            $this->ayamAfkirPopulasi->where('populasi_ayam_id', '=', $populasiAyam->id)->delete();
        }
    }

    public function saveAyamKarantina(PopulasiAyam $populasiAyam)
    {
        // get kandangId
        $kandangId = $populasiAyam->kandang_id;

        // save ayam masuk karantina
        if (@$populasiAyam->ayam_masuk_karantina) {
            $kpp = $this->karantinaPopulasiPipe->updateOrCreate([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'kandang_asal_id'       => $populasiAyam->kandang_id,
                'flock_asal_id'         => $populasiAyam->flock_id,
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
                'kandang_asal_id'       => $populasiAyam->kandang_id,
                'flock_asal_id'         => $populasiAyam->flock_id,
                'pipe_asal_id'          => $populasiAyam->pipe_id,
            ])->delete();
        }

        // save ayam keluar karantina
        if (@$populasiAyam->ayam_keluar_karantina) {
            $kpp = $this->karantinaPopulasiPipe->updateOrCreate([
                'populasi_ayam_asal_id' => $populasiAyam->id,
                'tanggal'               => $populasiAyam->tanggal,
                'kandang_tujuan_id'     => $populasiAyam->kandang_id,
                'flock_tujuan_id'       => $populasiAyam->flock_id,
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
                'kandang_tujuan_id'     => $populasiAyam->kandang_id,
                'flock_tujuan_id'       => $populasiAyam->flock_id,
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
            ->join('pipe AS p', function ($query) {
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

    public function saveAyamPindah(Collection $items, $tanggal): void
    {
        foreach ($items as $item) {
            if (! empty($item['pindah_ayam'])) {
                foreach ($item['pindah_ayam'] as $pindah) {
                    $tujuanPipeId = $pindah['pipe_tujuan_id'];
                    $jumlah       = (int) $pindah['jumlah_perubahan'];

                    if ($jumlah === 0) {
                        continue;
                    }

                    $populasiAyamId = $item['id'] ?? null;

                    $this->ayamPindah->updateOrCreate([
                        'tanggal'       => $tanggal,
                        'asal_pipe_id'  => $item['pipe_id'],
                        'tujuan_pipe_id'=> $tujuanPipeId,
                    ], [
                        'user_pic_id'      => auth()->id(),
                        'populasi_ayam_id' => $populasiAyamId,
                        'jumlah_perubahan' => $jumlah,
                    ]);
                }
            }
        }
    }

    public function getAyamPindahByKandang($kandangId, $tanggal)
    {
        return $this->ayamPindah
            ->whereHas('asalPipe.flock', function ($query) use ($kandangId) {
                $query->where('kandang_id', '=', $kandangId);
            })
            ->whereDate('tanggal', '=', $tanggal)
            ->get()
            ->mapToGroups(function ($item) {
                return [$item->asal_pipe_id => $item];
            });
    }
}
