<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanFormulasiRepository extends EloquentRepository
{
    public function __construct(BahanPakanFormulasi $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->join('users', 'users.id', '=', 'bahan_pakan_formulasi.pic_user_id')
            ->leftJoin('jenis_pakan', 'jenis_pakan.id', '=', 'bahan_pakan_formulasi.jenis_pakan_id')
            ->selectRaw(<<<SQL
                bahan_pakan_formulasi.*
                , users.name as nama_pic_user
                , jenis_pakan.nama as nama_jenis_pakan
                , bahan_pakan_formulasi.tipe
            SQL);
        return $query;
    }

    public function save(array $data): BahanPakanFormulasi
    {
        $bahanPakanFormulasi = $this->model->updateOrCreate([
            'id'    => @$data['id'],
        ], [
            'pic_user_id'       => @$data['pic_user_id'],
            'jenis_pakan_id'    => @$data['jenis_pakan_id'],
            'tipe'              => @$data['tipe'],
            'nama'              => @$data['nama'],
        ]);

        $savedFormulasiIds = [];
        foreach ($data['items'] as $item) {
            $formulasi = $bahanPakanFormulasi->bahanPakanFormulasiItem()->updateOrCreate([
                'id' => @$item['id'],
            ], [
                "bahan_pakan_id" => @$item['bahan_pakan_id'],
                "persentase" => @$item['persentase'],
            ]);
            $savedFormulasiIds[] = $formulasi->id;
        }
        $bahanPakanFormulasi->bahanPakanFormulasiItem()->whereNotIn('id', $savedFormulasiIds);

        $savedBeratIds = [];
        foreach ($data['berat_pakan'] as $item) {
            $berat = $bahanPakanFormulasi->bahanPakanFormulasiBerat()->updateOrCreate([
                'id' => @$item['id'],
            ], [
                "berat" => @$item['berat'],
            ]);
            $savedBeratIds[] = $berat->id;
        }
        $bahanPakanFormulasi->bahanPakanFormulasiBerat()->whereNotIn('id', $savedBeratIds);

        return $bahanPakanFormulasi;
    }
}