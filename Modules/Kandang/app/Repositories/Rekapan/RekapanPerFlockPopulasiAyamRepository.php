<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanPerFlockPopulasiAyamRepository extends EloquentRepository
{
    use KandangTanggalTrait;

    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.flock_id
                , pa.kandang_id
                , pa.tanggal
                , MAX(pa.umur_ayam_record) as umur
                , SUM(pa.ayam_sehat) as sehat
                , SUM(pa.ayam_mati) as mati
                , SUM(pa.ayam_afkir) as afkir
            SQL)
            ->groupBy('pa.flock_id', 'pa.tanggal')
            ->where('pa.kandang_id', '=', $this->kandangId)
            ->whereDate('pa.tanggal', '=', $this->tanggal);

        $akumulasi = DB::table('populasi_ayam as pa2')
            ->selectRaw(<<<SQL
                pa2.flock_id
                , pa2.kandang_id
                , pa2.tanggal
                , SUM(pa2.ayam_mati) as akumulasi_mati
                , SUM(pa2.ayam_afkir) as akumulasi_afkir
            SQL)
            ->groupBy('pa2.flock_id', 'pa2.tanggal')
            ->where('pa2.kandang_id', '=', $this->kandangId)
            ->whereDate('pa2.tanggal', '<=', $this->tanggal);

        $akumulasiKarantina = DB::table('karantina_populasi_pipe as kpp')
            ->selectRaw(<<<SQL
                kpp.tanggal
                , kpp.flock_asal_id
                , kpp.flock_tujuan_id
                , SUM(kpp.ayam_masuk_karantina) as masuk_karantina
                , SUM(kpp.ayam_keluar_karantina) as keluar_karantina
            SQL)
            ->groupBy('kpp.flock_asal_id', 'kpp.flock_tujuan_id', 'kpp.tanggal')
            ->where(function($join) {
                $join->where('kpp.kandang_asal_id', '=', $this->kandangId);
                $join->orWhere('kpp.kandang_tujuan_id', '=', $this->kandangId);
            })
            ->whereDate('kpp.tanggal', '=', $this->tanggal);

        return $this->model
            ->query()
            ->fromSub($base, 'xpa')
            ->join('kandang', 'kandang.id', '=', 'xpa.kandang_id')
            ->join('flock', 'flock.id', '=', 'xpa.flock_id')
            ->leftJoinSub($akumulasi, 'xa', function ($join) {
                $join
                    ->on('xa.flock_id', '=', 'xpa.flock_id')
                    ->on('xa.tanggal', '<=', 'xpa.tanggal');
            })
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join
                    ->on('ssm.strain_id', '=', 'kandang.strain_id')
                    ->on('ssm.umur', 'xpa.umur');
            })
            ->leftJoinSub($akumulasiKarantina, 'xak', function($join) {
                $join->on(function ($q) {
                    $q
                        ->on('xpa.flock_id', '=', 'xak.flock_asal_id')
                        ->orOn('xpa.flock_id', '=', 'xak.flock_tujuan_id');
                })
                ->on('xpa.tanggal', 'xak.tanggal');
            })
            ->selectRaw(<<<SQL
                xpa.kandang_id
                , flock.id as flock_id
                , flock.nama as nama_flock
                , xpa.tanggal
                , xpa.umur
                , xpa.sehat
                , xpa.mati
                , SUM(xa.akumulasi_mati) as akumulasi_mati
                , SUM(xa.akumulasi_mati) / NULLIF(xpa.sehat, 0) as persen_mati
                , xpa.afkir
                , SUM(xa.akumulasi_afkir) as akumulasi_afkir
                , SUM(xa.akumulasi_afkir) / NULLIF(xpa.sehat, 0) as persen_afkir
                , SUM(xa.akumulasi_mati) + SUM(xa.akumulasi_afkir) as akumulasi_mati_afkir
                , (SUM(xa.akumulasi_mati) + SUM(xa.akumulasi_afkir)) / NULLIF(xpa.sehat, 0)  as persen_mati_afkir
                , ssm.persentase_kematian as standar_mati_afkir
                , xak.masuk_karantina
                , xak.keluar_karantina
            SQL)
            ->groupBy(
                'flock.id',
                'xpa.tanggal',
            );
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function ($q, $kandangId) {
                $q->where('kandang.id', '=', $kandangId);
            }
        ];
    }
}