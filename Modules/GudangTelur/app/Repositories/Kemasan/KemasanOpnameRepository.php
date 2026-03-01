<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanOpname;
use Modules\GudangTelur\Models\KemasanOutput;
use Modules\Kandang\Repositories\EloquentRepository;

class KemasanOpnameRepository extends EloquentRepository
{
    public function __construct(KemasanOpname $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users as pu', 'pu.id', '=', 'kemasan_opname.pic_user_id')
            ->selectRaw(<<<SQL
                kemasan_opname.id
                , kemasan_opname.tanggal
                , pu.name as nama_pic_user
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('pu.nama', 'LIKE', "%$search%");
    }

    public function save(array $data) : KemasanOpname
    {
        $payload['tanggal']         = @$data['tanggal'];
        if (@$data['pic_user_id']) {
            $payload['pic_user_id'] = @$data['pic_user_id'];
        }

        $kemasanOpname = $this->model->newInstance()->updateOrCreate([
            'id'            => @$data['id'],
        ], $payload);

        $savedKemasanInventoryIds = [];
        foreach ($data['items'] as $item) {
            $kemasanInventory = $kemasanOpname->kemasanInventory()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'tipe'              => TipeKemasanInventory::OPNAME->value,
                'tanggal'           => @$data['tanggal'],
                'kemasan_opname_id' => $kemasanOpname->id,
                'kemasan_id'        => @$item['kemasan_id'],
                'jumlah'            => @$item['jumlah'],
            ]);
            $savedKemasanInventoryIds[] = $kemasanInventory->id;
        }
        $kemasanOpname->kemasanInventory()->whereNotIn('id', $savedKemasanInventoryIds)->delete();

        return $kemasanOpname;
    }
}