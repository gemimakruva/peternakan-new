<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class KemasanInventoryRepository extends EloquentRepository
{
    public function __construct(KemasanInventory $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $baseQuery = DB::table('kemasan_inventory')
            ->selectRaw(<<<SQL
                kemasan_id
                , kemasan_inventory.tanggal
                , sum(kemasan_inventory.jumlah) as jumlah
                , kemasan_inventory.tipe
            SQL)
            ->groupBy('tanggal', 'kemasan_id', 'tipe');

        $saldoQuery = DB::table('kemasan_inventory', 'xki')
            ->join('kemasan', 'kemasan.id', '=', 'xki.kemasan_id')
            ->leftJoinSub($baseQuery, 'xinput', function ($join) {
                $join
                    ->on('xinput.kemasan_id', '=', 'xki.kemasan_id')
                    ->on('xinput.tanggal', '<=', 'xki.tanggal')
                    ->where('xinput.tipe', '=', TipeKemasanInventory::INPUT->value);
            })
            ->selectRaw(<<<SQL
                xki.kemasan_id
                , xki.tanggal
                , sum(xinput.jumlah) as jumlah
                , xki.tipe
                , kemasan.nama
            SQL)
            ->groupBy('xki.kemasan_id', 'xki.tanggal')
            ->orderByDesc('xki.tanggal');

        $query = $this->model
            ->query()
            ->leftJoinSub($saldoQuery, 'xsq', function ($join) {
                $join->on('xsq.kemasan_id', '=', 'kemasan_inventory.kemasan_id');
            })
            ->selectRaw(<<<SQL
                kemasan_inventory.kemasan_id
                , max(xsq.tanggal) as tanggal
                , xsq.jumlah as saldo
                , xsq.nama as nama_kemasan
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