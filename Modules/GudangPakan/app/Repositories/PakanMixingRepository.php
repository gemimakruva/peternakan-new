<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanFormulasiItemTipe;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\GudangPakan\Models\PakanMixing;
use Modules\GudangPakan\Models\PakanPreMixing;
use Modules\GudangPakan\Models\PakanPreMixingInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class PakanMixingRepository extends EloquentRepository
{
    public function __construct(PakanMixing $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->join('users', 'users.id', '=', 'pakan_mixing.pic_user_id')
            ->join('bahan_pakan_formulasi', 'bahan_pakan_formulasi.id', '=', 'pakan_mixing.formulasi_mix_id')
            ->selectRaw(<<<SQL
                pakan_mixing.id
                , users.name as nama_pic_user
                , bahan_pakan_formulasi.nama as nama_formulasi
                , pakan_mixing.jumlah_campuran
                , pakan_mixing.harga_total
                , pakan_mixing.tanggal
            SQL);

        return $query;
    }

    public function save(array $data): PakanMixing
    {
        $pakanMixing = $this->model->updateOrCreate([
            'id'                => @$data['id'],
        ], [
            'pic_user_id'       => @$data['pic_user_id'],
            'formulasi_mix_id'  => @$data['formulasi_mix_id'],
            'tanggal'           => @$data['tanggal'],
            'jumlah_campuran'   => @$data['jumlah_campuran'],
        ]);

        $pakanMixing->load([
            'formulasiMix.bahanPakanFormulasiItem.bahanPakan.satuan',
            'formulasiMix.bahanPakanFormulasiItem.formulasiPremix',
        ]);

        $listFormulasi = $pakanMixing->formulasiMix->bahanPakanFormulasiItem->map(function ($item) use($pakanMixing) {
            if ($item->tipe === BahanPakanFormulasiItemTipe::PREMIX) {
                return [
                    'tipe' => $item->tipe,
                    'bahan_pakan_id' => null,
                    'formulasi_premix_id' => $item->formulasi_premix_id, // as jenis same as bahan_pakan_id
                    'jumlah' => $pakanMixing->jumlah_campuran*($item->persentase/100),
                    'harga_sub_total' => ($pakanMixing->jumlah_campuran*($item->persentase/100))*$item->formulasiPremix->harga_per_kg
                ];
            } elseif ($item->tipe === BahanPakanFormulasiItemTipe::RAW) {
                return [
                    'tipe' => $item->tipe,
                    'bahan_pakan_id' => $item->bahan_pakan_id,
                    'formulasi_premix_id' => null,
                    'jumlah' => ($item->persentase/100)/($item->bahanPakan->satuan->konversi_satuan/1000)*$pakanMixing->jumlah_campuran,
                    'harga_sub_total' => (($item->bahanPakan->harga_satuan/($item->bahanPakan->satuan->konversi_satuan/1000)) * ($item->persentase/100))*$pakanMixing->jumlah_campuran,
                ];
            } else {
                return [
                    'tipe' => null,
                    'bahan_pakan_id' => null,
                    'formulasi_premix_id' => null,
                    'jumlah' => 0,
                    'harga_sub_total' => 0,
                ];
            }
        });

        $pakanMixingItemIds = [];
        foreach ($listFormulasi as $formulasi) {
            $pakanMixingItem = $pakanMixing->pakanMixingItem()->updateOrCreate([
                'bahan_pakan_id' => $formulasi['bahan_pakan_id'],
                'formulasi_premix_id' => $formulasi['formulasi_premix_id'],
            ], [
                'jumlah' => $formulasi['jumlah'],
                'harga_sub_total' => $formulasi['harga_sub_total'],
            ]);
            $pakanMixingItemIds[] = $pakanMixingItem->id;

            if ($formulasi['tipe'] === BahanPakanFormulasiItemTipe::PREMIX) {
                app(PakanPreMixingInventory::class)->updateOrCreate([
                    'tipe' => PakanPreMixingInventoryTipe::KELUAR->value,
                    'pakan_mixing_item_id' => $pakanMixingItem->id,
                    'formulasi_premix_id' => $formulasi['formulasi_premix_id'],
                ], [
                    'tanggal' => $pakanMixing->tanggal->format('Y-m-d'),
                    'jumlah' => $formulasi['jumlah'],
                ]);
            } elseif ($formulasi['tipe'] === BahanPakanFormulasiItemTipe::RAW) {
                app(BahanPakanInventory::class)->updateOrCreate([
                    'tipe' => BahanPakanInventoryTipe::KELUAR->value,
                    'pakan_mixing_item_id' => $pakanMixingItem->id,
                    'bahan_pakan_id' => $formulasi['bahan_pakan_id'],
                ], [
                    'tanggal' => $pakanMixing->tanggal->format('Y-m-d'),
                    'jumlah' => $pakanMixing->jumlah_campuran,
                ]);
            }
        }
        $pakanMixing->pakanMixingItem()->whereNotIn('id', $pakanMixingItemIds)->delete();

        $pakanMixing->harga_total = $listFormulasi->sum('harga_sub_total');
        $pakanMixing->save();

        return $pakanMixing;
    }
}