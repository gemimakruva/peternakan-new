<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanFormulasiItemTipe;
use Modules\GudangPakan\Enums\BahanPakanFormulasiTipe;
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

    /**
     * get formulasi khusus premix
     * @param mixed $bahanPakanFormulasiId
     * @return array
     */
    public function getSelectItems2($bahanPakanFormulasiId = null)
    {
        return $this->model
            ->where('tipe', '=', BahanPakanFormulasiTipe::PRE_MIXING->value)
            ->when($bahanPakanFormulasiId, function ($q, $bahanPakanFormulasiId) {
                $q->where('id', '<>', $bahanPakanFormulasiId);
            })
            ->pluck('nama', 'id')
            ->toArray();
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
        foreach ((@$data['items'] ?? []) as $item) {
            $newFormulasi = (@$item['tipe'] == BahanPakanFormulasiItemTipe::RAW->value)
                ? [
                    "tipe" => @$item['tipe'],
                    "persentase" => @$item['persentase'],
                    "bahan_pakan_id" => @$item['bahan_pakan_id'],
                ] : [
                    "tipe" => @$item['tipe'],
                    "persentase" => @$item['persentase'],
                    "formulasi_premix_id" => @$item['formulasi_premix_id'],
                ];

            $formulasi = $bahanPakanFormulasi->bahanPakanFormulasiItem()->updateOrCreate([
                'id' => @$item['id'],
            ], $newFormulasi);

            $savedFormulasiIds[] = $formulasi->id;
        }
        $bahanPakanFormulasi->bahanPakanFormulasiItem()->whereNotIn('id', $savedFormulasiIds)->delete();

        $savedBeratIds = [];
        foreach ((@$data['berat_pakan'] ?? []) as $item) {
            $berat = $bahanPakanFormulasi->bahanPakanFormulasiBerat()->updateOrCreate([
                'id' => @$item['id'],
            ], [
                "berat" => @$item['berat'],
            ]);
            $savedBeratIds[] = $berat->id;
        }
        $bahanPakanFormulasi->bahanPakanFormulasiBerat()->whereNotIn('id', $savedBeratIds)->delete();

        return $bahanPakanFormulasi;
    }
}