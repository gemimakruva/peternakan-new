<?php

namespace Modules\Kandang\Repositories\Rekapan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\ProduksiTelur;
use Modules\Kandang\Repositories\EloquentRepository;

class RekapanProduksiTelurRepository extends EloquentRepository
{
    public function __construct(ProduksiTelur $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
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

        $populasiQuery = DB::table('populasi_ayam as pa')
            ->selectRaw(<<<SQL
                pa.kandang_id
                , pa.tanggal
                , MAX(pa.umur_ayam_record) as umur
                , SUM(pa.ayam_sehat) as sehat
            SQL)
            ->groupBy('pa.kandang_id', 'pa.tanggal');

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

        $query = $this->model
            ->query()
            ->join('kandang', 'kandang.id', '=', 'produksi_telur.kandang_id')
            ->leftJoinSub($foodIntakeQuery, 'xfi', function ($join) {
                $join->on('xfi.kandang_id', '=', 'produksi_telur.kandang_id')
                    ->on('xfi.tanggal', '=', 'produksi_telur.tanggal');
            })
            ->leftJoinSub($pengadaanQuery, 'xp', function ($join) {
                $join->on('xp.kandang_id', '=', 'produksi_telur.kandang_id');
            })
            ->leftJoinSub($populasiQuery, 'xpa', function ($join) {
                $join->on('xpa.kandang_id', '=', 'produksi_telur.kandang_id')
                    ->on('xpa.tanggal', '=', 'produksi_telur.tanggal');
            })
            ->leftJoinSub($produksiTelurQuery, 'xpt', function ($join) {
                $join->on('xpt.kandang_id', '=', 'produksi_telur.kandang_id')
                    ->on('xpt.tanggal', '=', 'produksi_telur.tanggal');
            })
            ->selectRaw(<<<SQL
                produksi_telur.kandang_id
                , kandang.nama as nama_kandang
                , produksi_telur.tanggal
                , produksi_telur.umur_ayam
                , xp.jumlah_ayam_pengadaan
                , xpa.sehat as jumlah_ayam
                , xpt.jumlah_telur_bagus as jumlah_telur_bagus
                , xpt.jumlah_telur_putih as jumlah_telur_putih
                , xpt.jumlah_telur_reject as jumlah_telur_reject
                , (xpt.jumlah_telur_bagus+xpt.jumlah_telur_putih+xpt.jumlah_telur_reject) as total_jumlah_telur
                , xpt.berat_telur_bagus as berat_telur_bagus
                , xpt.berat_telur_putih as berat_telur_putih
                , xpt.berat_telur_reject as berat_telur_reject
                , (xpt.berat_telur_bagus+xpt.berat_telur_putih+xpt.berat_telur_reject) as total_berat_telur
                , (xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xpa.sehat as hdp
                , (xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xp.jumlah_ayam_pengadaan as hhp
                , (xfi.food_intake)/(xpt.berat_telur_bagus + xpt.berat_telur_putih + xpt.berat_telur_reject) as fcr
                , (xpt.berat_telur_bagus + xpt.berat_telur_putih)/(xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih)*1000 as egg_weight
                , ((xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih + xpt.jumlah_telur_reject)/xp.jumlah_ayam_pengadaan)
                    * (xpt.berat_telur_bagus + xpt.berat_telur_putih)/(xpt.jumlah_telur_bagus + xpt.jumlah_telur_putih)*1000 as egg_mass
            SQL)
            ->groupBy(
                'produksi_telur.kandang_id',
                'produksi_telur.tanggal'
            );

        return $query;
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function ($q, $kandangId) {
                $q->where('produksi_telur.kandang_id', '=', $kandangId);
            },
            'tanggal' => function ($q, $tanggal) {
                $q->where('produksi_telur.tanggal', '=', $tanggal);
            }
        ];
    }
}