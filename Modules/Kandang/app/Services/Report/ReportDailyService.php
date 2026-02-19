<?php

namespace Modules\Kandang\Services\Report;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\Pakan\OverviewPakanHarianRepository;


class ReportDailyService
{
    public function __construct(
        private OverviewPakanHarianRepository $overviewPakanHarianRepository,
        private PopulasiAyam $populasiAyam,
        private Kandang $kandang,
    ) { }

    public function populasiAyamPerKandang(Carbon $tanggal)
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal    
                , SUM(pa.ayam_sehat) as ayam_sehat
                , SUM(pa.ayam_mati) as ayam_mati
                , SUM(pa.ayam_afkir) as ayam_afkir
                , SUM(pa.ayam_masuk_karantina) as ayam_masuk_karantina
                , SUM(pa.ayam_keluar_karantina) as ayam_keluar_karantina
            SQL)
            ->whereDate('pa.tanggal', '=', $tanggal)
            ->groupBy('pa.kandang_id', 'pa.tanggal');

        $query = DB::query()
            ->fromSub($base, 'xpa')
            ->join('kandang as k', 'k.id', '=', 'xpa.kandang_id')
            ->selectRaw(<<<SQL
                xpa.kandang_id
                , k.nama as nama_kandang
                , xpa.ayam_sehat
                , xpa.ayam_mati
                , xpa.ayam_afkir
                , xpa.ayam_masuk_karantina
                , xpa.ayam_keluar_karantina
            SQL)
            ->whereDate('xpa.tanggal', '=', $tanggal)
            ->groupBy('xpa.kandang_id', 'xpa.tanggal');

        return $query->get();
    }

    public function populasiAyamSemuaKandang(Carbon $tanggal)
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal    
                , SUM(pa.ayam_sehat) as ayam_sehat
                , SUM(pa.ayam_mati) as ayam_mati
                , SUM(pa.ayam_afkir) as ayam_afkir
                , SUM(pa.ayam_masuk_karantina) as ayam_masuk_karantina
                , SUM(pa.ayam_keluar_karantina) as ayam_keluar_karantina
            SQL)
            ->whereDate('pa.tanggal', '=', $tanggal)
            ->groupBy('pa.tanggal');

        $query = DB::query()
            ->fromSub($base, 'xpa')
            ->join('kandang as k', 'k.id', '=', 'xpa.kandang_id')
            ->selectRaw(<<<SQL
                xpa.ayam_sehat
                , xpa.ayam_mati
                , xpa.ayam_afkir
                , xpa.ayam_masuk_karantina
                , xpa.ayam_keluar_karantina
            SQL)
            ->whereDate('xpa.tanggal', '=', $tanggal)
            ->groupBy('xpa.tanggal');

        return $query->first();
    }

    public function akumulasiKematianAyamPerKandang(Carbon $tanggal)
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
            SQL)
            ->groupBy('pa.kandang_id', 'pa.tanggal')
            ->whereDate('pa.tanggal', '=', $tanggal);

        $akumulasi = DB::table('populasi_ayam as pa2')
            ->selectRaw(<<<SQL
                pa2.kandang_id
                , pa2.tanggal
                , SUM(pa2.ayam_mati) as akumulasi_mati
                , SUM(pa2.ayam_afkir) as akumulasi_afkir
            SQL)
            ->groupBy('pa2.kandang_id', 'pa2.tanggal')
            ->whereDate('pa2.tanggal', '<=', $tanggal);

        $query = DB::query()
            ->fromSub($base, 'xpa')
            ->join('kandang as k', 'k.id', '=', 'xpa.kandang_id')
            ->leftJoinSub($akumulasi, 'xa', function ($join) {
                $join
                    ->on('xa.kandang_id', '=', 'xpa.kandang_id')
                    ->on('xa.tanggal', '<=', 'xpa.tanggal');
            })
            ->selectRaw(<<<SQL
                xpa.kandang_id
                , k.nama as nama_kandang
                , sum(xa.akumulasi_mati) as akumulasi_mati
                , sum(xa.akumulasi_afkir) as akumulasi_afkir
                , (sum(xa.akumulasi_mati) + sum(xa.akumulasi_afkir)) as akumulasi_mati_afkir
            SQL)
            ->groupBy('xpa.kandang_id', 'xpa.tanggal')
            ->whereDate('xpa.tanggal', '=', $tanggal);

        return $query->get();
    }

    public function akumulasiKematianAyamSemuaKandang(Carbon $tanggal)
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
            SQL)
            ->groupBy('pa.tanggal')
            ->whereDate('pa.tanggal', '=', $tanggal);

        $akumulasi = DB::table('populasi_ayam as pa2')
            ->selectRaw(<<<SQL
                pa2.kandang_id
                , pa2.tanggal
                , SUM(pa2.ayam_mati) as akumulasi_mati
                , SUM(pa2.ayam_afkir) as akumulasi_afkir
            SQL)
            ->groupBy('pa2.tanggal')
            ->whereDate('pa2.tanggal', '<=', $tanggal);

        $query = DB::query()
            ->fromSub($base, 'xpa')
            ->leftJoinSub($akumulasi, 'xa', function ($join) {
                $join->on('xa.tanggal', '<=', 'xpa.tanggal');
            })
            ->selectRaw(<<<SQL
                sum(xa.akumulasi_mati) as akumulasi_mati
                , sum(xa.akumulasi_afkir) as akumulasi_afkir
                , (sum(xa.akumulasi_mati) + sum(xa.akumulasi_afkir)) as akumulasi_mati_afkir
            SQL)
            ->groupBy('xpa.tanggal')
            ->whereDate('xpa.tanggal', '=', $tanggal);

        return $query->first();
    }

    public function persentaseAkumulasiKematianAyamPerKandang(Carbon $tanggal)
    {
        $base = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
                , SUM(pa.ayam_sehat) as sehat
                , MAX(pa.umur_ayam_record) as umur
            SQL)
            ->groupBy('pa.kandang_id', 'pa.tanggal')
            ->whereDate('pa.tanggal', '=', $tanggal);
        
        $akumulasi = DB::table('populasi_ayam as pa2')
            ->selectRaw(<<<SQL
                pa2.kandang_id
                , pa2.tanggal
                , SUM(pa2.ayam_mati) as akumulasi_mati
                , SUM(pa2.ayam_afkir) as akumulasi_afkir
            SQL)
            ->groupBy('pa2.kandang_id', 'pa2.tanggal')
            ->whereDate('pa2.tanggal', '<=', $tanggal);

        $query = DB::query()
            ->fromSub($base, 'xpa')
            ->join('kandang', 'kandang.id', '=', 'xpa.kandang_id')
            ->leftJoinSub($akumulasi, 'xa', function ($join) {
                $join->on('xa.kandang_id', '=', 'xpa.kandang_id')
                    ->whereColumn('xa.tanggal', '<=', 'xpa.tanggal');
            })
            ->leftJoin('strain_standart_metric as ssm', function($join) {
                $join->on('ssm.strain_id', '=', 'kandang.strain_id')
                    ->whereColumn('ssm.umur', 'xpa.umur');
            })
            ->selectRaw(<<<SQL
                kandang.id as kandang_id
                , kandang.nama as nama_kandang
                , SUM(xa.akumulasi_mati) / NULLIF(xpa.sehat, 0)*100 as persen_mati
                , SUM(xa.akumulasi_afkir) / NULLIF(xpa.sehat, 0)*100 as persen_afkir
                , (SUM(xa.akumulasi_mati) + SUM(xa.akumulasi_afkir)) / NULLIF(xpa.sehat, 0)*100  as persen_mati_afkir
                , ssm.persentase_kematian as standar_mati_afkir
            SQL)
            ->groupBy('kandang.id', 'xpa.tanggal')
            ->whereDate('xpa.tanggal', '=', $tanggal);

        return $query->get();
    }

    public function konsumsiAyamPerKandang(Carbon $tanggal)
    {
        $query = $this->overviewPakanHarianRepository
            ->getQuery()
            ->groupBy('id_kandang')
            ->whereDate('tanggal_pemberian_pakan', '=', $tanggal);

        $data = $query->get()->map(function($item) {
            return [
                'nama_kandang'                  => $item->nama_kandang,
                'feed_intake_per_ekor'          => $item->feed_intake_per_ekor,
                'feed_intake_per_ekor_standar'  => $item->feed_intake_per_ekor_standar,
            ];
        });

        $data->push([
            'nama_kandang'                      => 'Rata - rata',
            'feed_intake_per_ekor'              => $data->avg('feed_intake_per_ekor'), 
            'feed_intake_per_ekor_standar'      => $data->avg('feed_intake_per_ekor_standar')
        ]);

        return $data;
    }
}