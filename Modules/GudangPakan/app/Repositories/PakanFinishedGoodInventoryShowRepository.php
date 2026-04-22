<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanFinishedGoodInventoryTipe;
use Modules\GudangPakan\Models\PakanFinishedGoodInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanFinishedGoodInventoryShowRepository extends EloquentRepository
{
    private $bahanPakanFormulasiId;

    public function __construct(PakanFinishedGoodInventory $model)
    {
        parent::__construct($model);
    }

    public function setContenxt($bahanPakanFormulasiId)
    {
        $this->bahanPakanFormulasiId = $bahanPakanFormulasiId;
        return $this;
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_finished_good_inventory.formulasi_mix_id')
            ->when($this->bahanPakanFormulasiId, function ($query, $bahanPakanFormulasiId) {
                $query->where('pakan_finished_good_inventory.formulasi_mix_id', '=', $bahanPakanFormulasiId);
            })
            ->selectRaw(<<<SQL
                bahan_pakan_formulasi.id
                , bahan_pakan_formulasi.nama as nama_formulasi
                , pakan_finished_good_inventory.tanggal
                , pakan_finished_good_inventory.tipe
                , pakan_finished_good_inventory.jumlah
                , SUM(
                    CASE
                        WHEN pakan_finished_good_inventory.tipe = ? THEN pakan_finished_good_inventory.jumlah
                        WHEN pakan_finished_good_inventory.tipe = ? THEN -pakan_finished_good_inventory.jumlah
                        WHEN pakan_finished_good_inventory.tipe = ? THEN pakan_finished_good_inventory.jumlah
                        ELSE 0
                    END
                ) OVER (
                    ORDER BY 
                        pakan_finished_good_inventory.tanggal ASC
                        , pakan_finished_good_inventory.created_at ASC
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) as saldo
            SQL, [
                PakanFinishedGoodInventoryTipe::MASUK->value,
                PakanFinishedGoodInventoryTipe::KELUAR->value,
                PakanFinishedGoodInventoryTipe::OPNAME->value,
            ]);

        return $query;
    }
}