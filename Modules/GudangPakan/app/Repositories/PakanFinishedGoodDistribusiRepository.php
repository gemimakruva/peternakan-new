<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\PakanFinishedGoodInventoryTipe;
use Modules\GudangPakan\Models\PakanFinishedGoodDistribusi;
use Modules\GudangPakan\Models\PakanFinishedGoodInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanFinishedGoodDistribusiRepository extends EloquentRepository
{
    public function __construct(PakanFinishedGoodDistribusi $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'pakan_finished_good_distribusi.pic_user_id')
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_finished_good_distribusi.formulasi_mix_id')
            ->selectRaw(<<<SQL
                pakan_finished_good_distribusi.id
                , pakan_finished_good_distribusi.tanggal
                , users.name as nama_pic_user
                , bahan_pakan_formulasi.nama as nama_formulasi
                , pakan_finished_good_distribusi.jumlah
                , pakan_finished_good_distribusi.tujuan
            SQL);

        return $query;
    }

    public function save(array $data) : PakanFinishedGoodDistribusi 
    {
        $distribusi = $this->model->updateOrCreate([
            'id' => @$data['id'],
        ], [
            'pic_user_id' => @$data['pic_user_id'],
            'formulasi_mix_id' => @$data['formulasi_mix_id'],
            'tanggal' => @$data['tanggal'],
            'jumlah' => @$data['jumlah'],
            'tujuan' => @$data['tujuan'],
        ]);

        app(PakanFinishedGoodInventory::class)->updateOrCreate([
            'tipe' => PakanFinishedGoodInventoryTipe::KELUAR,
            'pakan_finished_good_distribusi_id' => $distribusi->id,
        ], [
            'formulasi_mix_id' => $distribusi->formulasi_mix_id,
            'tanggal' => $distribusi->tanggal,
            'jumlah' => $distribusi->jumlah,
        ]);

        return $distribusi;
    }
}