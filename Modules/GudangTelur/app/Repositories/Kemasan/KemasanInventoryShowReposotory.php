<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class KemasanInventoryShowReposotory extends EloquentRepository
{
    private $kemasanId;

    public function __construct(KemasanInventory $model)
    {
        parent::__construct($model);
    }

    public function setContext($kemasanId)
    {
        $this->kemasanId = $kemasanId;
        return $this;
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
            ->groupBy(
                'tanggal'
                , 'kemasan_id'
                , 'tipe'
            );

        $query = $this->model->query()
            ->from('kemasan_inventory', 'xki')
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
                , xki.jumlah
                , xki.tipe
                , sum(xinput.jumlah) as saldo
                , kemasan.nama as nama_kemasan
            SQL)
            ->where('xki.kemasan_id', '=', $this->kemasanId)
            ->groupBy(
                'xki.kemasan_id'
                , 'xki.tanggal'
                , 'xki.tipe'
                , 'xki.jumlah'
            )
            ->orderByDesc('xki.tanggal');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy("xki.tanggal", 'desc');
        $q->orderBy("nama_kemasan", 'asc');
    }
}
