<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Enums\TipeKemasanInventory;
use Modules\GudangTelur\Models\KemasanOutput;
use Modules\GudangTelur\Models\TelurKeluar;
use Modules\GudangTelur\Models\TelurTujuan;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurKeluarRepository extends EloquentRepository
{
    public function __construct(TelurKeluar $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'telur_keluar.pic_user_id')
            ->join('telur_tujuan', 'telur_tujuan.id', '=', 'telur_keluar.telur_tujuan_id')
            ->selectRaw(<<<SQL
                telur_keluar.id
                , telur_keluar.tanggal
                , users.name as nama_pic_user
                , telur_tujuan.nama as nama_telur_tujuan
            SQL);

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q
            ->where('users.name', 'LIKE', "%$search%")
            ->orWhere('telur_tujuan.nama', 'LIKE', "%$search%");
    }

    public function save(array $data)
    {
        if (!is_numeric($data['telur_tujuan_id'])) {
            $data['telur_tujuan_id'] = app(TelurTujuan::class)->firstOrCreate(['nama' => $data['telur_tujuan_id']])->id;
        }

        // Kemasan Output
        $kemasanOutput  = app(KemasanOutput::class)->firstOrCreate([
            "id"                => @$data['kemasan_output_id'],
        ], [
            "pic_user_id"       => @$data['pic_user_id'],
            "tanggal"           => @$data['tanggal'],
        ]);

        // Kemasan Output Items
        $savedKemasanInventoryIds = [];
        foreach ($data['kemasan_items'] as $item) {
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

        // Telur Keluar
        $telurKeluar = $this->model->firstOrCreate([
            "id"                => @$data['id'],
        ], [
            "pic_user_id"       => @$data['pic_user_id'],
            "kemasan_output_id" => $kemasanOutput->id,
            "telur_tujuan_id"   => @$data['telur_tujuan_id'],
            "tanggal"           => @$data['tanggal'],
        ]);

        // Telur Keluar Items
        $savedTelurInventoryIds = [];
        foreach ($data['items'] as $item) {
            if (!@$item['jumlah'] || @$item['jumlah'] == 0) continue;
            $telurInventory = $telurKeluar->telurInventory()->updateOrCreate([
                'id'                => @$item['id'],
            ], [
                'tanggal'           => @$data['tanggal'],
                'telur_jenis_id'    => @$item['telur_jenis_id'],
                'jumlah'            => @$item['jumlah'],
            ]);
            $savedTelurInventoryIds[] = $telurInventory->id;
        }
        $telurKeluar->telurInventory()->whereNotIn('id', $savedTelurInventoryIds)->delete();

        return $telurKeluar;
    }
}