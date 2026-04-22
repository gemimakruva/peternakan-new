<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanOpname;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanOpnameRepository extends EloquentRepository
{
    public function __construct(BahanPakanOpname $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'bahan_pakan_opname.pic_user_id')
            ->selectRaw(<<<SQL
                bahan_pakan_opname.id
                , users.name as nama_pic_user
                , bahan_pakan_opname.tanggal
            SQL);
        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('bahan_pakan_opname.tanggal');
        $q->orderByDesc('bahan_pakan_opname.created_at');
        $q->orderByDesc('bahan_pakan_opname.id');
    }

    public function save(array $data)
    {
        $opname = $this->model->updateOrCreate([
            'id' => @$data['id'],
        ], [
            'pic_user_id' => @$data['pic_user_id'],
            'tanggal' => @$data['tanggal'],
        ]);

        if (!@$data['items'] || !count($data['items'])) {
            return $opname;
        }

        $savedBahanPakanInventoryIds = [];
        foreach ($data['items'] as $item) {
            $mwaTerakhir = app(BahanPakanInventoryShowRepository::class)->getLatestMwa($item['bahan_pakan_id']);
            $bahanPakanInventory = $opname->bahanPakanInventory()->updateOrCreate([
                'id'                            => @$item['id'],
            ], [
                'tipe'                          => BahanPakanInventoryTipe::OPNAME->value,
                'tanggal'                       => @$data['tanggal'],
                'bahan_pakan_opname_id'         => $opname->id,
                'bahan_pakan_id'                => @$item['bahan_pakan_id'],
                'jumlah'                        => @$item['jumlah'],
                'harga_satuan'                  => $mwaTerakhir,
            ]);

            $savedBahanPakanInventoryIds[] = $bahanPakanInventory->id;
        }
        $opname->bahanPakanInventory()->whereNotIn('id', $savedBahanPakanInventoryIds)->delete();

        return $opname;
    }

    public function delete(int|string $id): bool
    {
        $masuk = $this->model->where('id', '=', $id)->first();
        if (!$masuk) return false;
        $masuk->bahanPakanInventory()->delete();
        return $masuk->delete();
    }
}