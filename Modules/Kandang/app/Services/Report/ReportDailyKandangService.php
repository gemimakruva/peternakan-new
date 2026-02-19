<?php

namespace Modules\Kandang\Services\Report;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Repositories\Rekapan\RekapanPakanHarianRepository;


class ReportDailyKandangService
{
    public function __construct(
        private RekapanPakanHarianRepository $rekapanPakanHarianRepository,
        private PopulasiAyam $populasiAyam,
        private Kandang $kandang,
    ) { }

    public function populasiAyamPerFlock()
    {

    }

    public function populasiAyamKandang()
    {
        
    }

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
        $query = $this->rekapanPakanHarianRepository
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

    public function produksiTelurSemuaKandang(Carbon $tanggal)
    {
        $produksiTelurQuery = DB::table('produksi_telur_item')
            ->selectRaw(<<<SQL
                kandang_id
                , tanggal
                , SUM(jumlah_telur_bagus) as jumlah_telur_bagus
                , SUM(jumlah_telur_putih) as jumlah_telur_putih
                , SUM(jumlah_telur_reject) as jumlah_telur_reject
                , SUM(berat_telur_bagus) as berat_telur_bagus
                , SUM(berat_telur_putih) as berat_telur_putih
                , SUM(berat_telur_reject) as berat_telur_reject
            SQL)
            ->groupBy('kandang_id', 'tanggal');

        $query = DB::table('produksi_telur as pt')
            ->join('kandang', 'kandang.id', '=', 'pt.kandang_id')
            ->leftJoinSub($produksiTelurQuery, 'xpt', function ($join) {
                $join->on('xpt.kandang_id', '=', 'pt.kandang_id')
                    ->on('xpt.tanggal', '=', 'pt.tanggal');
            })
            ->selectRaw(<<<SQL
                pt.id
                , pt.kandang_id
                , kandang.nama as nama_kandang
                , (xpt.jumlah_telur_bagus+xpt.jumlah_telur_putih+xpt.jumlah_telur_reject) as total_jumlah_telur
                , (xpt.berat_telur_bagus+xpt.berat_telur_putih+xpt.berat_telur_reject) as total_berat_telur
            SQL)
            ->whereDate('pt.tanggal', '=', $tanggal);
        
        return $query->get();
    }

    public function kpiProduksi(Carbon $tanggal)
    {
        $produksiTelurQuery = DB::table('produksi_telur_item')
            ->selectRaw(<<<SQL
                kandang_id
                , tanggal
                , SUM(jumlah_telur_bagus) as jumlah_telur_bagus
                , SUM(jumlah_telur_putih) as jumlah_telur_putih
                , SUM(jumlah_telur_reject) as jumlah_telur_reject
                , SUM(berat_telur_bagus) as berat_telur_bagus
                , SUM(berat_telur_putih) as berat_telur_putih
                , SUM(berat_telur_reject) as berat_telur_reject
            SQL)
            ->groupBy('kandang_id', 'tanggal')
            ->whereDate('tanggal', '=', $tanggal);
        
        $populasiQuery = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
                , SUM(pa.ayam_sehat) as sehat
            SQL)
            ->groupBy('pa.kandang_id', 'pa.tanggal')
            ->whereDate('pa.tanggal', '=', $tanggal);
        
        $latestPengadaan = DB::table('pengadaan_ayam as pa')
            ->joinSub(
                DB::table('pengadaan_ayam')
                    ->selectRaw('kandang_id, MAX(tanggal) as tanggal')
                    ->groupBy('kandang_id'),
                'x',
                function ($join) {
                    $join->on('x.kandang_id', '=', 'pa.kandang_id')
                        ->on('x.tanggal', '=', 'pa.tanggal');
                }
            )
            ->select('pa.id');

        $pengadaanQuery = DB::table('pengadaan_ayam_distribusi as pad')
            ->selectRaw(<<<SQL
                pad.kandang_id
                , SUM(pad.jumlah_ayam) as jumlah_ayam_pengadaan
            SQL)
            ->whereIn('pad.pengadaan_ayam_id', $latestPengadaan)
            ->groupBy('pad.kandang_id');

        $pakanQuery = DB::table('perhitungan_pakan_item as ppi')
            ->selectRaw(<<<SQL
                AVG(ppi.pemberian_pakan_per_ekor)*SUM(ppi.jumlah_ayam)/1000 as pemberian_pakan
                , ppi.perhitungan_pakan_id
            SQL)
            ->groupBy('ppi.perhitungan_pakan_id');

        $sisaPakanQuery = DB::table('pemberian_pakan_sisa_pakan as ppsp')
            ->selectRaw(<<<SQL
                SUM(sisa_pakan_per_flock_kg) as sisa_pakan
                , ppsp.perhitungan_pakan_id
            SQL)
            ->groupBy('ppsp.perhitungan_pakan_id');

        $foodIntakeQuery = DB::table('perhitungan_pakan as pp')
            ->leftJoinSub($pakanQuery, 'xp', function ($join) {
                $join->on('xp.perhitungan_pakan_id', '=', 'pp.id');
            })
            ->leftJoinSub($sisaPakanQuery, 'xsp', function ($join) {
                $join->on('xsp.perhitungan_pakan_id', '=', 'pp.id');
            })
            ->selectRaw(<<<SQL
                pp.kandang_id
                , pp.tanggal_pemberian_pakan as tanggal
                , NULLIF(xp.pemberian_pakan, 0) - NULLIF(xsp.sisa_pakan, 0) as food_intake
            SQL)
            ->groupBy(
                'pp.id'
                , 'pp.kandang_id'
                , 'pp.tanggal_pemberian_pakan'
            );

        $query = DB::table('produksi_telur as pt')
            ->join('kandang', 'kandang.id', '=', 'pt.kandang_id')
            ->leftJoinSub($produksiTelurQuery, 'xpt', function ($join) {
                $join->on('xpt.kandang_id', '=', 'pt.kandang_id')
                    ->on('xpt.tanggal', '=', 'pt.tanggal');
            })
            ->leftJoinSub($populasiQuery, 'xpa', function ($join) {
                $join->on('xpa.kandang_id', '=', 'pt.kandang_id')
                    ->on('xpa.tanggal', '=', 'pt.tanggal');
            })
            ->leftJoinSub($pengadaanQuery, 'xp', function ($join) {
                $join->on('xp.kandang_id', '=', 'pt.kandang_id');
            })
            ->leftJoinSub($foodIntakeQuery, 'xfi', function ($join) {
                $join->on('xfi.kandang_id', '=', 'pt.kandang_id')
                    ->on('xfi.tanggal', '=', 'pt.tanggal');
            })
            ->selectRaw(<<<SQL
                pt.id
                , pt.kandang_id
                , kandang.nama as nama_kandang
                , (xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xpa.sehat as hdp
                , (xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xp.jumlah_ayam_pengadaan as hhp
                , (xfi.food_intake)/(xpt.berat_telur_bagus + xpt.berat_telur_putih + xpt.berat_telur_reject) as fcr
                , (xpt.berat_telur_bagus + xpt.berat_telur_putih)/(xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih)*1000 as egg_weight
                , ((xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xp.jumlah_ayam_pengadaan)
                    * (xpt.berat_telur_bagus + xpt.berat_telur_putih)/(xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih)*1000 as egg_mass
            SQL)
            ->whereDate('pt.tanggal', '=', $tanggal);
        
        return $query->get();
    }
}