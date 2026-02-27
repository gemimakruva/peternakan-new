<?php

namespace Modules\GudangTelur\Repositories\Kemasan;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanInput;
use Modules\Kandang\Repositories\EloquentRepository;

class KemasanInputRepository extends EloquentRepository
{
    public function __construct(KemasanInput $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->from('kemasan_input')
            ->join('users as pu', 'pu.id', '=', 'kemasan_input.pic_user_id')
            ->join('supplier as s', 's.id', '=', 'kemasan_input.supplier_id')
            ->selectRaw(<<<SQL
                kemasan_input.id
                , kemasan_input.tanggal
                , pu.name as nama_pic_user
                , s.nama as nama_supplier
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q
            ->where('pu.nama', 'LIKE', "%$search%")
            ->orWhere('s.nama', 'LIKE', "%$search%");
    }

    public function save(array $data) : KemasanInput
    {
        $kemasanInput = $this->model->newInstance()->updateOrCreate([
            'id'            => @$data['id'],
        ], [
            'pic_user_id'   => @$data['pic_user_id'],
            'supplier_id'   => (int) @$data['supplier_id'],
            'tanggal'       => @$data['tanggal'],
        ]);

        $savedKemasanInventoryIds = [];
        foreach ($data['items'] as $item) {
            $kemasanInventory = $kemasanInput->kemasanInventory()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'tipe'              => TipeKemasanInventory::INPUT->value,
                'tanggal'           => @$data['tanggal'],
                'supplier_id'       => @$data['supplier_id'],
                'kemasan_input_id'  => $kemasanInput->id,
                'kemasan_id'        => @$item['kemasan_id'],
                'jumlah'            => @$item['jumlah'],
            ]);
            $savedKemasanInventoryIds[] = $kemasanInventory->id;
        }
        $kemasanInput->kemasanInventory()->whereNotIn('id', $savedKemasanInventoryIds)->delete();

        return $kemasanInput;
    }
}