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
        $query = $this->model->query()
            ->from('kemasan_inventory as xki')
            ->join('kemasan', 'kemasan.id', '=', 'xki.kemasan_id')
            ->selectRaw(<<<SQL
                xki.kemasan_id,
                xki.tanggal,
                xki.jumlah,
                xki.tipe,
                kemasan.nama as nama_kemasan,
                SUM(
                    CASE
                        WHEN xki.tipe = ? THEN xki.jumlah
                        WHEN xki.tipe = ? THEN -xki.jumlah
                        WHEN xki.tipe = ? THEN xki.jumlah
                        ELSE 0
                    END
                ) OVER (
                    PARTITION BY xki.kemasan_id
                    ORDER BY xki.tanggal
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) as saldo
            SQL, [
                TipeKemasanInventory::INPUT->value,
                TipeKemasanInventory::OUTPUT->value,
                TipeKemasanInventory::OPNAME->value,
            ])
            ->where('xki.kemasan_id', $this->kemasanId)
            ->orderByDesc('xki.tanggal')
            ->orderByDesc('xki.created_at');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy("xki.tanggal", 'desc');
        $q->orderBy("nama_kemasan", 'asc');
    }
}
