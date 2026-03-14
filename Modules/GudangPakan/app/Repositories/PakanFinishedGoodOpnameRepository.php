<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanFinishedGoodInventoryTipe;
use Modules\GudangPakan\Models\PakanFinishedGoodOpname;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanFinishedGoodOpnameRepository extends EloquentRepository
{
    public function __construct(PakanFinishedGoodOpname $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'pakan_finished_good_opname.pic_user_id')
            ->selectRaw(<<<SQL
                pakan_finished_good_opname.id
                , users.name as nama_pic_user
                , pakan_finished_good_opname.tanggal
            SQL);
        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('pakan_finished_good_opname.tanggal');
        $q->orderByDesc('pakan_finished_good_opname.created_at');
        $q->orderByDesc('pakan_finished_good_opname.id');
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

        $savedInventoryIds = [];
        foreach ($data['items'] as $item) {
            $inventory = $opname->pakanFinishedGoodInventory()->updateOrCreate([
                'id'                            => @$item['id'],
            ], [
                'tipe'                          => PakanFinishedGoodInventoryTipe::OPNAME->value,
                'tanggal'                       => @$data['tanggal'],
                'formulasi_mix_id'              => @$item['formulasi_mix_id'],
                'jumlah'                        => @$item['jumlah'],
            ]);

            $savedInventoryIds[] = $inventory->id;
        }
        $opname->pakanFinishedGoodInventory()->whereNotIn('id', $savedInventoryIds)->delete();

        return $opname;
    }
}