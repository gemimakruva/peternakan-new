<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanInventoryRepository extends EloquentRepository
{
    public function __construct(BahanPakanInventory $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->leftJoin('bahan_pakan', 'bahan_pakan.id', '=', 'bahan_pakan_inventory.bahan_pakan_id')
            ->leftJoin('satuan', 'satuan.id', '=', 'bahan_pakan.satuan_id')
            ->selectRaw(<<<SQL
                bahan_pakan.id
                , bahan_pakan.tipe
                , bahan_pakan.nama as nama_bahan_pakan
                , bahan_pakan.harga_satuan
                , satuan.nama as nama_satuan
                , sum(bahan_pakan_inventory.jumlah) as jumlah
            SQL)
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
}