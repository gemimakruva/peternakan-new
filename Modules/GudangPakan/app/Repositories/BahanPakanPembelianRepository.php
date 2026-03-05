<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\BahanPakanPembelian;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanPembelianRepository extends EloquentRepository
{
    public function __construct(BahanPakanPembelian $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'bahan_pakan_pembelian.pic_user_id')
            ->join('supplier', 'supplier.id', '=', 'bahan_pakan_pembelian.supplier_id')
            ->selectRaw(<<<SQL
                bahan_pakan_pembelian.id
                , users.name as nama_pic_user
                , supplier.nama as nama_supplier
                , bahan_pakan_pembelian.tanggal_pesan
                , bahan_pakan_pembelian.tanggal_datang
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('tanggal_pesan');
        $q->orderByDesc('bahan_pakan_pembelian.created_at');
        $q->orderByDesc('bahan_pakan_pembelian.id');
    }

    public function save(array $data)
    {
        // dd($data);
        $newPembelian = [
            'tanggal_pesan'     => @$data['tanggal_pesan'],
            'tanggal_datang'    => @$data['tanggal_datang'],
        ];

        if (@$data['pic_user_id']) {
            $newPembelian['pic_user_id'] = @$data['pic_user_id'];
        }

        if (@$data['supplier_id']) {
            $newPembelian['supplier_id'] = @$data['supplier_id'];
        }

        $pembelian = $this->model->updateOrCreate([
            'id' => @$data['id'],
        ], $newPembelian);

        if (!@$data['items'] || !count($data['items'])) {
            return $pembelian;
        }

        $savedPembelianBahanPakanIds = [];
        foreach ($data['items'] as $item) {
            $pembelianItem = $pembelian->bahanPakanPembelianItem()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'bahan_pakan_id'    => @$item['bahan_pakan_id'],
                'harga_satuan'      => @$item['harga_satuan'],
                'jumlah'            => @$item['jumlah'],
            ]);

            $savedPembelianBahanPakanIds[] = $pembelianItem->id;
        }
        $pembelian->bahanPakanPembelianItem()->whereNotIn('id', $savedPembelianBahanPakanIds)->delete();

        return $pembelian;
    }
}