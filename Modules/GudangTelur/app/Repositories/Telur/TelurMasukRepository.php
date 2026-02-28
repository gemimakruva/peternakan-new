<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Models\TelurAsal;
use Modules\GudangTelur\Models\TelurMasuk;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurMasukRepository extends EloquentRepository
{
    public function __construct(TelurMasuk $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'telur_masuk.pic_user_id')
            ->join('telur_asal', 'telur_asal.id', '=', 'telur_masuk.telur_asal_id')
            ->selectRaw(<<<SQL
                telur_masuk.id
                , telur_masuk.tanggal
                , users.name as nama_pic_user
                , telur_asal.nama as nama_telur_asal
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q
            ->where('users.name', 'LIKE', "%$search%")
            ->orWhere('telur_asal.nama', 'LIKE', "%$search%");
    }

    public function save(array $data)
    {
        if (!is_numeric($data['telur_asal_id'])) {
            $data['telur_asal_id'] = app(TelurAsal::class)->firstOrCreate(['nama' => $data['telur_asal_id']])->id;
        }

        $telurMasuk = $this->model->firstOrCreate([
            'id'    => @$data['id'],
        ], [
            "pic_user_id"   => @$data['pic_user_id'],
            "telur_asal_id" => @$data['telur_asal_id'],
            "tanggal"       => @$data['tanggal'],
        ]);

        $savedTelurInventoryIds = [];
        foreach ($data['items'] as $item) {
            if (!@$item['jumlah'] || @$item['jumlah'] == 0) continue;
            $telurInventory = $telurMasuk->telurInventory()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'tanggal'           => @$data['tanggal'],
                'telur_jenis_id'    => @$item['telur_jenis_id'],
                'jumlah'            => @$item['jumlah'],
            ]);
            $savedTelurInventoryIds[] = $telurInventory->id;
        }
        $telurMasuk->telurInventory()->whereNotIn('id', $savedTelurInventoryIds)->delete();

        return $telurMasuk;
    }
}