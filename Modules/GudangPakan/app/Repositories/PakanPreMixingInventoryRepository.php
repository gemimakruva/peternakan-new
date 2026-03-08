<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\PakanPreMixingInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanPreMixingInventoryRepository extends EloquentRepository
{
    public function __construct(PakanPreMixingInventory $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_pre_mixing_inventory.formulasi_premix_id')
            ->selectRaw(<<<SQL
                pakan_pre_mixing_inventory.id
                , bahan_pakan_formulasi.nama as nama_formulasi
                , sum(pakan_pre_mixing_inventory.jumlah) as jumlah
            SQL)
            ->groupBy('bahan_pakan_formulasi.id');

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('bahan_pakan_formulasi.nama', 'LIKE', "%$search%");
    }
}