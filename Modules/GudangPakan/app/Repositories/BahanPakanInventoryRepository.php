<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanInventoryRepository extends EloquentRepository
{
    private ?string $exceptColumn = null;
    private ?array $exceptIds = null;

    public function __construct(BahanPakanInventory $model)
    {
        parent::__construct($model);
    }

    public function setContext($exceptColumn = null, $exceptIds = null) {
        if ($exceptColumn) $this->exceptColumn = $exceptColumn;
        if ($exceptIds) $this->exceptIds = $exceptIds;
        return $this;
    }

    public function getQuery(): Builder
    {
        $notInSql = "";
        if ($this->exceptColumn && $this->exceptIds) {
            $placeholders = implode(',', $this->exceptIds);
            $notInSql = "AND bahan_pakan_inventory.$this->exceptColumn NOT IN ($placeholders)";
        }

        $query = $this->model->query()
            ->leftJoin('bahan_pakan', 'bahan_pakan.id', '=', 'bahan_pakan_inventory.bahan_pakan_id')
            ->leftJoin('satuan', 'satuan.id', '=', 'bahan_pakan.satuan_id')
            ->selectRaw(<<<SQL
                bahan_pakan.id
                , bahan_pakan.tipe
                , bahan_pakan.nama as nama_bahan_pakan
                , bahan_pakan.harga_satuan
                , satuan.nama as nama_satuan
                , sum(
                    CASE
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        WHEN bahan_pakan_inventory.tipe = ? $notInSql THEN -bahan_pakan_inventory.jumlah
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        ELSE 0
                    END
                ) as jumlah
            SQL, [
                BahanPakanInventoryTipe::MASUK->value,
                BahanPakanInventoryTipe::KELUAR->value,
                BahanPakanInventoryTipe::OPNAME->value,
            ])
            ->groupBy('bahan_pakan_inventory.bahan_pakan_id');
        return $query;
    }

    public function customWhereQuery(): array
    {
        return [
            'tipe'  => function ($query, $tipe) {
                $query->where('bahan_pakan.tipe', '=', $tipe);
            }
        ];
    }

    public function findByBahanPakanId($bahanPakanId)
    {
        $bahanPakan = $this->getQuery()->where('bahan_pakan.id', '=', $bahanPakanId)->first();
        return $bahanPakan;
    }
}