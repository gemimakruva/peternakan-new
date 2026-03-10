<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\GudangPakan\Models\BahanPakanMasuk;
use Modules\GudangPakan\Models\BahanPakanPembelian;
use Modules\GudangPakan\Enums\BahanPakanMasukAsal;
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

        $this->saveInventory($pembelian);

        return $pembelian;
    }

    public function delete(int|string $id): bool
    {
        $bahanPakanPembelian = $this->model->where('id', '=', $id)->first();

        if (!$bahanPakanPembelian) {
            return false;
        }

        $bahanPakanPembelian->bahanPakanMasuk?->bahanPakanInventory()?->delete();
        $bahanPakanPembelian->bahanPakanMasuk()->delete();
        $bahanPakanPembelian->bahanPakanPembelianItem()->delete();
        return (boolean) $this->model->where('id', '=', $id)->delete();
    }

    private function saveInventory(BahanPakanPembelian $bahanPakanPembelian)
    {
        $bahanPakanPembelian->load('bahanPakanPembelianItem');
        $data = $bahanPakanPembelian->toArray();

        if (
            !@$data['tanggal_datang'] || 
            !@$data['bahan_pakan_pembelian_item'] ||
            !count($data['bahan_pakan_pembelian_item'])
        ) {
            return;
        }

        $newBahanPakanMasuk = [
            'supplier_id'               => $data['supplier_id'],
            'pic_user_id'               => $data['pic_user_id'],
            'asal'                      => BahanPakanMasukAsal::DARI_PEMBELIAN->value,
            'tanggal'                   => $data['tanggal_datang'],
        ];

        $bahanPakanMasuk = app(BahanPakanMasuk::class)->updateOrCreate([
            'bahan_pakan_pembelian_id'  => $data['id'],
        ], $newBahanPakanMasuk);

        foreach ($data['bahan_pakan_pembelian_item'] as $item) {
            $newBahanPakanInventory = [
                'tipe'                          => BahanPakanInventoryTipe::MASUK,
                'tanggal'                       => $data['tanggal_datang'],
                'bahan_pakan_masuk_id'          => $bahanPakanMasuk->id,
                'bahan_pakan_id'                => $item['bahan_pakan_id'],
                'jumlah'                        => $item['jumlah'],
            ];

            $bahanPakanMasuk->bahanPakanInventory()->updateOrCreate([
                'bahan_pakan_pembelian_item_id' => $item['id'],
            ], $newBahanPakanInventory);
        }
    }
}