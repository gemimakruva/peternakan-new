<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;
use Modules\GudangPakan\Models\PakanPreMixingOpname;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanPreMixingOpnameRepository extends EloquentRepository
{
    public function __construct(PakanPreMixingOpname $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'pakan_pre_mixing_opname.pic_user_id')
            ->selectRaw(<<<SQL
                pakan_pre_mixing_opname.id
                , users.name as nama_pic_user
                , pakan_pre_mixing_opname.tanggal
            SQL);
        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('users.name', 'LIKE', "%$search%");
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('pakan_pre_mixing_opname.tanggal');
        $q->orderByDesc('pakan_pre_mixing_opname.created_at');
        $q->orderByDesc('pakan_pre_mixing_opname.id');
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
            $inventory = $opname->pakanPreMixingInventory()->updateOrCreate([
                'id'                            => @$item['id'],
            ], [
                'tipe'                          => PakanPreMixingInventoryTipe::OPNAME->value,
                'tanggal'                       => @$data['tanggal'],
                'formulasi_premix_id'           => @$item['formulasi_premix_id'],
                'jumlah'                        => @$item['jumlah'],
            ]);

            $savedInventoryIds[] = $inventory->id;
        }
        $opname->pakanPreMixingInventory()->whereNotIn('id', $savedInventoryIds)->delete();

        return $opname;
    }
}