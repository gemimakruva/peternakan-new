<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanMasuk;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanMasukRepository extends EloquentRepository
{
    public function __construct(BahanPakanMasuk $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'bahan_pakan_masuk.pic_user_id')
            ->leftJoin('supplier', 'supplier.id', '=', 'bahan_pakan_masuk.supplier_id')
            ->selectRaw(<<<SQL
                bahan_pakan_masuk.id
                , bahan_pakan_masuk.bahan_pakan_pembelian_id
                , users.name as nama_pic_user
                , supplier.nama as nama_supplier
                , bahan_pakan_masuk.tanggal
                , bahan_pakan_masuk.asal
            SQL);
        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('bahan_pakan_masuk.tanggal');
        $q->orderByDesc('bahan_pakan_masuk.created_at');
        $q->orderByDesc('bahan_pakan_masuk.id');
    }

    public function save(array $data)
    {
        $newBahanPakanMasuk = [
            'asal'      => @$data['asal'],
            'tanggal'   => @$data['tanggal'],
        ];

        if (@$data['supplier_id']) {
            $newBahanPakanMasuk['supplier_id'] = @$data['supplier_id'];
        }

        if (@$data['pic_user_id']) {
            $newBahanPakanMasuk['pic_user_id'] = @$data['pic_user_id'];
        }

        $bahanPakanMasuk = $this->model->updateOrCreate([
            'id' => @$data['id'],
        ], $newBahanPakanMasuk);

        if (!@$data['items'] || !count($data['items'])) {
            return $bahanPakanMasuk;
        }

        $savedBahanPakanInventoryIds = [];
        foreach ($data['items'] as $item) {
            $newBahanPakanInventory = [
                'tipe'                          => BahanPakanInventoryTipe::MASUK->value,
                'tanggal'                       => @$data['tanggal'],
                'bahan_pakan_masuk_id'          => $bahanPakanMasuk->id,
                'bahan_pakan_id'                => @$item['bahan_pakan_id'],
                'jumlah'                        => @$item['jumlah'],
            ];

            $bahanPakanInventory = $bahanPakanMasuk->bahanPakanInventory()->updateOrCreate([
                'id'                            => @$item['id'],
            ], $newBahanPakanInventory);

            $savedBahanPakanInventoryIds[] = $bahanPakanInventory->id;
        }
        $bahanPakanMasuk->bahanPakanInventory()->whereNotIn('id', $savedBahanPakanInventoryIds)->delete();

        return $bahanPakanMasuk;
    }

    public function delete(int|string $id): bool
    {
        $masuk = $this->model->where('id', '=', $id)->first();
        if (!$masuk) return false;
        $masuk->bahanPakanInventory()->delete();
        return $masuk->delete();
    }
}