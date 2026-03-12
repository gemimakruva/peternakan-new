<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanFinishedGoodInventoryTipe;
use Modules\GudangPakan\Models\PakanFinishedGoodInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanFinishedGoodInventoryRepository extends EloquentRepository
{
    public function __construct(PakanFinishedGoodInventory $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_finished_good_inventory.formulasi_mix_id')
            ->selectRaw(<<<SQL
                bahan_pakan_formulasi.id
                , bahan_pakan_formulasi.nama as nama_formulasi
                , sum(
                    CASE 
                        WHEN pakan_finished_good_inventory.tipe = ? THEN pakan_finished_good_inventory.jumlah
                        WHEN pakan_finished_good_inventory.tipe = ? THEN -pakan_finished_good_inventory.jumlah
                        WHEN pakan_finished_good_inventory.tipe = ? THEN pakan_finished_good_inventory.jumlah
                        ELSE 0
                    END
                ) as jumlah
            SQL, [
                PakanFinishedGoodInventoryTipe::MASUK->value,
                PakanFinishedGoodInventoryTipe::KELUAR->value,
                PakanFinishedGoodInventoryTipe::OPNAME->value,
            ])
            ->groupBy('pakan_finished_good_inventory.formulasi_mix_id');

        return $query;
    }
}