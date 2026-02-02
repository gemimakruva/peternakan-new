<?php

namespace Modules\Kandang\Repositories\Kandang;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PengadaanAyamDistribusi;
use Modules\Kandang\Repositories\EloquentRepository;

class KandangRepository extends EloquentRepository
{
    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->join('strain', 'strain.id', '=', 'kandang.strain_id')
            ->join('peternakan', 'peternakan.id', '=', 'kandang.peternakan_id')
            ->join('flock', 'flock.kandang_id', '=', 'kandang.id')
            ->join('pipe', 'pipe.flock_id', '=', 'flock.id')
            ->selectRaw(<<<SQL
                kandang.*
                , kandang.nama AS nama_kandang
                , strain.nama AS nama_strain
                , peternakan.nama AS nama_peternakan
                , SUM(pipe.kapasitas) AS kapasitas_kandang
            SQL)
            ->groupBy('kandang.id');
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('kandang.nama', 'LIKE', "%$search%");
    }

    public function populasiAyam(Collection $filter): Builder
    {
        $query = $this->model
            ->newQuery()
            ->leftJoinSub(
                // pengadaan ayam terbaru per kandang
                DB::table('pengadaan_ayam as pa1')
                    ->select(
                        'pa1.kandang_id',
                        'pa1.tanggal',
                        'pa1.umur_ayam',
                        'pa1.jumlah_ayam_masuk_kandang'
                    )
                    ->whereRaw('pa1.tanggal = (
                        SELECT MAX(pa2.tanggal)
                        FROM pengadaan_ayam pa2
                        WHERE pa2.kandang_id = pa1.kandang_id
                    )'),
                'pa',
                'pa.kandang_id',
                '=',
                'kandang.id'
            )
            ->leftJoinSub(
                // akumulasi populasi ayam per kandang
                DB::table('populasi_ayam as pa')
                    ->join('pipe as p', 'p.id', '=', 'pa.pipe_id')
                    ->join('flock as f', 'f.id', '=', 'p.flock_id')
                    ->when($filter->get('date_range'), function($query, $dateRange) {
                        $query->whereBetween('pa.tanggal', $dateRange);
                    })
                    ->groupBy('f.kandang_id')
                    ->select(
                        'f.kandang_id',
                        DB::raw('SUM(pa.ayam_mati) as ayam_mati'),
                        DB::raw('SUM(pa.ayam_afkir) as ayam_afkir'),
                        DB::raw('SUM(pa.ayam_masuk_karantina) as ayam_masuk_karantina'),
                        DB::raw('SUM(pa.ayam_keluar_karantina) as ayam_keluar_karantina'),
                        DB::raw('MAX(pa.tanggal) as terakhir_diperharui')
                    ),
                'x_total',
                'x_total.kandang_id',
                '=',
                'kandang.id'
            )
            ->select([
                'kandang.id',
                'kandang.nama',
                'pa.tanggal',
                'pa.umur_ayam',
            ])
            ->selectRaw('
                (
                    pa.jumlah_ayam_masuk_kandang
                    - COALESCE(x_total.ayam_mati, 0)
                    - COALESCE(x_total.ayam_afkir, 0)
                    - COALESCE(x_total.ayam_masuk_karantina, 0)
                    + COALESCE(x_total.ayam_keluar_karantina, 0)
                ) AS ayam_sehat
            ')
            ->addSelect([
                'x_total.ayam_mati',
                'x_total.ayam_afkir',
                'x_total.ayam_masuk_karantina',
                'x_total.ayam_keluar_karantina',
                'x_total.terakhir_diperharui',
            ]);
        
        return $query;
    }

    public function getUmurAyamByKandangId($kandangId, Carbon $tanggalPembanding): array|null
    {
        $data = app(PengadaanAyamDistribusi::class)
            ->join('pengadaan_ayam', 'pengadaan_ayam.id', '=', 'pengadaan_ayam_distribusi.pengadaan_ayam_id')
            ->where('pengadaan_ayam_distribusi.kandang_id', $kandangId)
            ->orderByDesc('pengadaan_ayam_distribusi.id')
            ->orderByDesc('pengadaan_ayam.tanggal')
            ->firstOrFail([
                'pengadaan_ayam.tanggal',
                'pengadaan_ayam.umur_ayam',
            ]);

        // Validasi apakah tanggal pengadaan ada
        if (!$data->tanggal || !$data->umur_ayam) {
            return null;
        }

        // Hitung umur ayam dalam minggu
        $tanggalPengadaan = Carbon::parse($data->tanggal)->startOfDay();
        $usiaAyamSaatPengadaan = $data->umur_ayam; // dalam minggu
        $selisihHariDariPengadaan = $tanggalPengadaan->diffInDays($tanggalPembanding);
        $selisihMingguDariPengadaan = floor($selisihHariDariPengadaan / 7);

        $usiaAyamSaatIni = $usiaAyamSaatPengadaan + $selisihMingguDariPengadaan;

        return [
            'usia_ayam' => $usiaAyamSaatIni,
            'usia_ayam_saat_pengadaan' => $usiaAyamSaatPengadaan,
            'selisih_minggu_dari_pengadaan' => $selisihMingguDariPengadaan,
            'tanggal_pengadaan' => $tanggalPengadaan->format('Y-m-d'),
            'tanggal_pembanding' => $tanggalPembanding->format('Y-m-d')
        ];
    }
}
