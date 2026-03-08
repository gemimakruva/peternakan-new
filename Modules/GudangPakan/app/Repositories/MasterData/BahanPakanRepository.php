<?php

namespace Modules\GudangPakan\Repositories\MasterData;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanRepository extends EloquentRepository
{
    public function __construct(BahanPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query();

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'LIKE', "%$search%");
    }

    public function save(array $data)
    {
        $bahanPakan = $this->model->updateOrCreate([
            'id'    => @$data['id'],
        ], [
            'tipe'  => @$data['tipe'],
            'nama'  => @$data['nama'],
            'satuan_id'  => @$data['satuan_id'],
            'harga' => @$data['harga'],
            'harga_satuan' => (float) @$data['harga'] / (float) @$data['jumlah_satuan'],
        ]);

        return $bahanPakan;
    }

    public function getSelectItemsWithSatuan($supplierId = null)
    {
        $datas = $this->model
            ->leftJoin('supplier_bahan_pakan', 'supplier_bahan_pakan.bahan_pakan_id', '=', 'bahan_pakan.id')
            ->when($supplierId, function ($query, $supplierId) {
                $query->where('supplier_bahan_pakan.supplier_id', '=', $supplierId);
            })
            ->with('satuan')
            ->get(['bahan_pakan.id', 'harga_satuan', 'nama', 'satuan_id'])
            ->map(function ($item) {
                return [
                    'id'        => $item->id,
                    'nama'      => $item->nama,
                    'satuan'    => $item->satuan->nama,
                    'harga_satuan'      => $item->harga_satuan,
                    'konversi_satuan'   => $item->satuan->konversi_satuan,
                ];
            });

        return $datas;
    }
}