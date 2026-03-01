<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanOutput;
use Modules\Kandang\Repositories\EloquentRepository;

class KemasanOutputRepository extends EloquentRepository
{
    public function __construct(KemasanOutput $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users as pu', 'pu.id', '=', 'kemasan_output.pic_user_id')
            ->selectRaw(<<<SQL
                kemasan_output.id
                , kemasan_output.tanggal
                , pu.name as nama_pic_user
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('pu.nama', 'LIKE', "%$search%");
    }

    public function save(array $data) : KemasanOutput
    {
        $payload['tanggal']         = @$data['tanggal'];
        if (@$data['pic_user_id']) {
            $payload['pic_user_id'] = @$data['pic_user_id'];
        }

        $kemasanOutput = $this->model->newInstance()->updateOrCreate([
            'id'            => @$data['id'],
        ], $payload);

        $savedKemasanInventoryIds = [];
        foreach ($data['items'] as $item) {
            $kemasanInventory = $kemasanOutput->kemasanInventory()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'tipe'              => TipeKemasanInventory::OUTPUT->value,
                'tanggal'           => @$data['tanggal'],
                'kemasan_output'    => $kemasanOutput->id,
                'kemasan_id'        => @$item['kemasan_id'],
                'jumlah'            => @$item['jumlah'],
            ]);
            $savedKemasanInventoryIds[] = $kemasanInventory->id;
        }
        $kemasanOutput->kemasanInventory()->whereNotIn('id', $savedKemasanInventoryIds)->delete();

        return $kemasanOutput;
    }
}