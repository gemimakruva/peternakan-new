<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\GudangPakan\Models\BahanPakanKeluar;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanKeluarRepository extends EloquentRepository
{
    public function __construct(BahanPakanKeluar $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'bahan_pakan_keluar.pic_user_id')
            ->selectRaw(<<<SQL
                bahan_pakan_keluar.id
                , users.name as nama_pic_user
                , bahan_pakan_keluar.tanggal
                , bahan_pakan_keluar.tujuan
            SQL);
        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('bahan_pakan_keluar.tanggal');
        $q->orderByDesc('bahan_pakan_keluar.created_at');
        $q->orderByDesc('bahan_pakan_keluar.id');
    }

    public function save(array $data): BahanPakanKeluar
    {
        $bahanPakanKeluar = $this->model->updateOrCreate([
            'id' => @$data['id']
        ], [
            'pic_user_id' => @$data['pic_user_id'],
            'tujuan' => @$data['tujuan'],
            'tanggal' => @$data['tanggal'],
        ]);

        $bahanPakanInventoryIds = [];
        foreach (($data['items'] ?? []) as $item) {
            $beforeInventory = app(BahanPakanInventory::class)->find($item['id']);
            $mwaTerakhir = app(BahanPakanInventoryShowRepository::class)->getLatestMwa($item['bahan_pakan_id'], $beforeInventory);
            $inventory = $bahanPakanKeluar->bahanPakanInventory()->updateOrCreate([
                'id' => $item['id'],
                'tipe' => BahanPakanInventoryTipe::KELUAR,
            ], [
                'bahan_pakan_id' => $item['bahan_pakan_id'],
                'tanggal' => @$data['tanggal'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $mwaTerakhir,
            ]);
            $bahanPakanInventoryIds[] = $inventory->id;
        }
        $bahanPakanKeluar->bahanPakanInventory()->whereNotIn('id', $bahanPakanInventoryIds)->delete();

        return $bahanPakanKeluar;
    }
}