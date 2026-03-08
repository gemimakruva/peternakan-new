<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\GudangPakan\Models\PakanPreMixing;
use Modules\GudangPakan\Models\PakanPreMixingInventory;
use Modules\GudangTelur\Models\Satuan;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanPreMixingRepository extends EloquentRepository
{
    public function __construct(PakanPreMixing $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'pakan_pre_mixing.pic_user_id')
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_pre_mixing.formulasi_premix_id')
            ->selectRaw(<<<SQL
                pakan_pre_mixing.id
                , users.name as nama_pic_user
                , bahan_pakan_formulasi.nama as nama_formulasi
                , pakan_pre_mixing.jumlah_campuran
                , pakan_pre_mixing.harga_total
            SQL);

        return $query;
    }

    public function save(array $data)
    {
        $pakanPreMixing = $this->model->updateOrCreate([
            'id'    => @$data['id']
        ], [
            'pic_user_id'           => @$data['pic_user_id'],
            'formulasi_premix_id'   => @$data['formulasi_premix_id'],
            'tanggal'               => @$data['tanggal'],
            'jumlah_campuran'       => @$data['jumlah_campuran'],
        ]);

        $pakanPreMixing->load([
            'formulasiPremix.bahanPakanFormulasiItem.bahanPakan.satuan'
        ]); 

        $listFormulasi = $pakanPreMixing->formulasiPremix->bahanPakanFormulasiItem->map(function ($item) use($pakanPreMixing) {
            return [
                'persentase' => $item->persentase,
                'bahan_pakan_id' => $item->bahan_pakan_id,
                'bahan_pakan_nama' => $item->bahanPakan->nama,
                'bahan_pakan_harga_per_satuan' => $item->bahanPakan->harga_satuan,
                'satuan_nama' => $item->bahanPakan->satuan->nama,
                'satuan_konversi' => $item->bahanPakan->satuan->konversi_satuan,
                'harga_per_kg' => $item->bahanPakan->harga_satuan/($item->bahanPakan->satuan->konversi_satuan/1000),

                'kebutuhan_per_kg' => ($item->persentase/100)/($item->bahanPakan->satuan->konversi_satuan/1000),
                'harga_per_kg_formulasi' => ($item->bahanPakan->harga_satuan/($item->bahanPakan->satuan->konversi_satuan/1000)) * ($item->persentase/100),

                'jumlah' => ($item->persentase/100)/($item->bahanPakan->satuan->konversi_satuan/1000)*$pakanPreMixing->jumlah_campuran,
                'harga_sub_total' => (($item->bahanPakan->harga_satuan/($item->bahanPakan->satuan->konversi_satuan/1000)) * ($item->persentase/100))*$pakanPreMixing->jumlah_campuran,
            ];
        });

        foreach ($listFormulasi as $formulasi) {            
            $pakanPreMixingItem = $pakanPreMixing->pakanPreMixingItem()->updateOrCreate([
                'bahan_pakan_id' => $formulasi['bahan_pakan_id'],
            ], [
                'jumlah' => $formulasi['jumlah'],
                'harga_sub_total' => $formulasi['harga_sub_total'],
            ]);

            app(BahanPakanInventory::class)->updateOrCreate([
                'tipe' => BahanPakanInventoryTipe::KELUAR->value,
                'pakan_pre_mixing_item_id' => $pakanPreMixingItem->id,
            ], [
                'tanggal' => $pakanPreMixing->created_at->format('Y-m-d'),
                'jumlah' => $pakanPreMixing->jumlah_campuran,
                'bahan_pakan_id' => $formulasi['bahan_pakan_id'],
            ]);
        }

        $pakanPreMixing->harga_total = $listFormulasi->sum('harga_sub_total');
        $pakanPreMixing->save();

        app(PakanPreMixingInventory::class)->updateOrCreate([
            'tipe' => PakanPreMixingInventoryTipe::MASUK,
            'pakan_pre_mixing_id' => $pakanPreMixing->id,
        ], [
            'formulasi_premix_id' => @$data['formulasi_premix_id'],
            'jumlah' => @$data['jumlah_campuran'],
        ]);

        return $pakanPreMixing;
    }
}