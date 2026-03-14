<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;
use Modules\GudangPakan\Models\PakanPreMixingInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanPreMixingInventoryShowRepository extends EloquentRepository
{
    private $bahanPakanFormulasiId;

    public function __construct(PakanPreMixingInventory $model)
    {
        parent::__construct($model);
    }

    public function setContext($bahanPakanFormulasiId)
    {
        $this->bahanPakanFormulasiId = $bahanPakanFormulasiId;
        return $this;
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_pre_mixing_inventory.formulasi_premix_id')
            ->selectRaw(<<<SQL
                pakan_pre_mixing_inventory.id
                , bahan_pakan_formulasi.nama as nama_formulasi
                , pakan_pre_mixing_inventory.jumlah
                , pakan_pre_mixing_inventory.tipe
                , pakan_pre_mixing_inventory.tanggal
                , pakan_pre_mixing_inventory.created_at
                , SUM(
                    CASE
                        WHEN pakan_pre_mixing_inventory.tipe = ? THEN pakan_pre_mixing_inventory.jumlah
                        WHEN pakan_pre_mixing_inventory.tipe = ? THEN -pakan_pre_mixing_inventory.jumlah
                        WHEN pakan_pre_mixing_inventory.tipe = ? THEN pakan_pre_mixing_inventory.jumlah
                        ELSE 0
                    END
                ) OVER (
                    ORDER BY 
                        pakan_pre_mixing_inventory.tanggal ASC
                        , pakan_pre_mixing_inventory.created_at ASC
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) as saldo
            SQL, [
                PakanPreMixingInventoryTipe::MASUK->value,
                PakanPreMixingInventoryTipe::KELUAR->value,
                PakanPreMixingInventoryTipe::OPNAME->value,
            ])
            ->where('bahan_pakan_formulasi.id', '=', $this->bahanPakanFormulasiId)
            ->groupBy('pakan_pre_mixing_inventory.id');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('pakan_pre_mixing_inventory.tanggal');
        $q->orderByDesc('pakan_pre_mixing_inventory.created_at');
        $q->orderByDesc('pakan_pre_mixing_inventory.id');
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('bahan_pakan_formulasi.nama', 'LIKE', "%$search%");
    }
}