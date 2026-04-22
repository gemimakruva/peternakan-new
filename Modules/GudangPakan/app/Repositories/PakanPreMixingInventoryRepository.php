<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;
use Modules\GudangPakan\Models\PakanPreMixingInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanPreMixingInventoryRepository extends EloquentRepository
{
    private ?string $exceptColumn = null;
    private ?array $exceptIds = null;

    public function __construct(PakanPreMixingInventory $model)
    {
        parent::__construct($model);
    }

    public function setContext($exceptColumn, $exceptIds) {
        $this->exceptColumn = $exceptColumn;
        $this->exceptIds = $exceptIds;
        return $this;
    }

    public function getQuery(): Builder
    {
        $notInSql = "";
        if ($this->exceptColumn && $this->exceptIds) {
            $placeholders = implode(',', $this->exceptIds);
            $notInSql = "AND pakan_pre_mixing_inventory.$this->exceptColumn NOT IN ($placeholders)";
        }

        $query = $this->model
            ->query()
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_pre_mixing_inventory.formulasi_premix_id')
            ->selectRaw(<<<SQL
                bahan_pakan_formulasi.id
                , bahan_pakan_formulasi.nama as nama_formulasi
                , sum(
                    CASE 
                        WHEN pakan_pre_mixing_inventory.tipe = ? THEN pakan_pre_mixing_inventory.jumlah
                        WHEN pakan_pre_mixing_inventory.tipe = ? $notInSql THEN -pakan_pre_mixing_inventory.jumlah
                        WHEN pakan_pre_mixing_inventory.tipe = ? THEN pakan_pre_mixing_inventory.jumlah
                        ELSE 0
                    END
                ) as jumlah
            SQL, [
                PakanPreMixingInventoryTipe::MASUK->value,
                PakanPreMixingInventoryTipe::KELUAR->value,
                PakanPreMixingInventoryTipe::OPNAME->value,
            ])
            ->groupBy('bahan_pakan_formulasi.id');

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('bahan_pakan_formulasi.nama', 'LIKE', "%$search%");
    }

    public function findByBahanPakanFormulasiId($bahanPakanFormulasiId)
    {
        $bahanPakanFormulasi = $this->getQuery()
            ->where('bahan_pakan_formulasi.id', '=', $bahanPakanFormulasiId)
            ->first();
        return $bahanPakanFormulasi;
    }
}