<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;
use Modules\Kandang\Repositories\EloquentRepository;

class SupplierRepository extends EloquentRepository
{
    public function __construct(Supplier $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->where('supplier.tipe', '=', SupplierTipe::BAHAN_PAKAN->value);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'LIKE', "%$search%");
    }

    public function save(array $data)
    {
        $supplier = $this->model->updateOrCreate([
            'id'            => @$data['id'],
        ], [
            'tipe'          => SupplierTipe::BAHAN_PAKAN->value,
            'nama'          => @$data['nama'],
            'badan_usaha'   => @$data['badan_usaha'],
            'kontak'        => @$data['kontak'],
            'alamat'        => @$data['alamat'],
            'lokasi'        => @$data['lokasi'],
        ]);

        if (!@$data['items'] || !count($data['items'])) {
            return $supplier;
        }

        $savedSupplierBahanPakanIds = [];
        foreach ($data['items'] as $item) {
            $supplierBahanPakan = $supplier->supplierBahanPakan()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'bahan_pakan_id'    => @$item['bahan_pakan_id'],
            ]);

            $savedSupplierBahanPakanIds[] = $supplierBahanPakan->id;
        }
        $supplier->supplierBahanPakan()->whereNotIn('id', $savedSupplierBahanPakanIds)->delete();

        return $supplier;
    }
}