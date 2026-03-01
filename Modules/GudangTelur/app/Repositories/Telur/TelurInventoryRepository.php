<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Modules\GudangTelur\Enums\TipeTelurInventory;
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
        $base = DB::query()
            ->from('telur_inventory as ti')
            ->join('telur_jenis as tj', 'tj.id', '=', 'ti.telur_jenis_id')
            ->selectRaw(<<<SQL
                ti.id
                , ti.tanggal
                , ti.jumlah
                , ti.tipe
                , ti.created_at
                , tj.nama as nama_jenis_telur,
                SUM(
                    CASE
                        WHEN ti.tipe = ? THEN ti.jumlah
                        WHEN ti.tipe = ? THEN -ti.jumlah
                        WHEN ti.tipe = ? THEN ti.jumlah
                        ELSE 0
                    END
                ) OVER (
                    ORDER BY 
                        ti.tanggal ASC
                        , ti.created_at ASC
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) as saldo
            SQL, [
                TipeTelurInventory::MASUK->value,
                TipeTelurInventory::KELUAR->value,
                TipeTelurInventory::OPNAME->value,
            ]);

        $query = $this->model
            ->query()
            ->fromSub($base, 'x');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy("x.tanggal", 'desc');
        $q->orderBy("x.created_at", 'desc');
        $q->orderBy("x.id", 'desc');
    }

    public function customWhereQuery(): array
    {
        return [
            'date_end' => function($query, $dateEnd) {
                $query->where('x.tanggal', '<=', $dateEnd);
            },
            'date_start' => function($query, $dateStart) {
                $query->where('x.tanggal', '>=', $dateStart);
            },
        ];
    }
}