<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurInventoryRepository extends EloquentRepository
{
    public function __construct(KemasanInventory $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $mutasiHarian = DB::table('telur_inventory as ki')
            ->selectRaw('
                ki.kemasan_id
                , ki.tanggal
                , SUM(
                    CASE 
                        WHEN ki.tipe = ? THEN ki.jumlah
                        WHEN ki.tipe = ? THEN -ki.jumlah
                        ELSE 0
                    END
                ) as mutasi
                , ki.kemasan_output_id
            ', [
                TipeKemasanInventory::INPUT->value,
                TipeKemasanInventory::OUTPUT->value,
            ])
            ->groupBy('ki.kemasan_id', 'ki.tanggal');

        $saldoQuery = DB::query()
            ->fromSub($mutasiHarian, 'm1')
            ->leftJoinSub($mutasiHarian, 'm2', function ($join) {
                $join->on('m2.kemasan_id', '=', 'm1.kemasan_id')
                    ->on('m2.tanggal', '<=', 'm1.tanggal');
            })
            ->join('kemasan', 'kemasan.id', '=', 'm1.kemasan_id')
            ->leftJoin('satuan', 'satuan.id', '=', 'kemasan.satuan_id')
            ->selectRaw('
                m1.kemasan_id
                , m1.tanggal
                , SUM(m2.mutasi) as jumlah
                , kemasan.nama
                , satuan.nama as nama_satuan
            ')
            ->groupBy(
                'm1.kemasan_id'
                , 'm1.tanggal'
                , 'kemasan.nama'
                , 'satuan.nama'
            )
            ->orderByDesc('m1.tanggal');

        $query = $this->model
            ->query()
            ->leftJoinSub($saldoQuery, 'xsq', function ($join) {
                $join->on('xsq.kemasan_id', '=', 'kemasan_inventory.kemasan_id');
            })
            ->selectRaw(<<<SQL
                kemasan_inventory.kemasan_id
                , max(xsq.tanggal) as tanggal
                , xsq.jumlah as stok
                , xsq.nama as nama_kemasan
                , xsq.nama_satuan
            SQL)
            ->groupBy('kemasan_inventory.kemasan_id');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy("xsq.tanggal", 'desc');
        $q->orderBy("nama_kemasan", 'asc');
    }
}