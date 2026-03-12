<?php

namespace Modules\GudangPakan\Services;

use Modules\GudangPakan\Models\BahanPakanFormulasi;
use Modules\GudangPakan\Repositories\BahanPakanInventoryRepository;
use Modules\GudangPakan\Repositories\PakanPreMixingInventoryRepository;

class MixingPakanService
{
    public function validateStokKebutuhanMixing(int $formulasiId, float $jumlahCampuran, ?string $exceptColumn = null, ?array $exceptIds = null)
    {
        $formulasi = app(BahanPakanFormulasi::class)
            ->with('bahanPakanFormulasiItem.bahanPakan.satuan')
            ->where('id', '=', $formulasiId)
            ->first();
        foreach ($formulasi->bahanPakanFormulasiItem as $item) {
            if ($item->bahan_pakan_id) {
                // get saldo dengan pengecualian pre/mixing terupdate
                $saldo = app(BahanPakanInventoryRepository::class)
                    ->setContext($exceptColumn, $exceptIds)
                    ->findByBahanPakanId($item->bahan_pakan_id);
            } else if($item->formulasi_premix_id) {
                // get saldo dengan pengecualian pre/mixing terupdate
                $saldo = app(PakanPreMixingInventoryRepository::class)
                    ->setContext($exceptColumn, $exceptIds)
                    ->findByBahanPakanFormulasiId($item->formulasi_premix_id);
                $saldo->jumlah = (float) $saldo->jumlah;
            } else {
                return "Formulasi Tidak Valid.";
            }

            $kebutuhan = $item->kebutuhanPerKg?->kebutuhan*$jumlahCampuran;
            $namaBahan = $item->kebutuhanPerKg->bahan;
            $namaSatuan = $item->kebutuhanPerKg->satuan;
            if ($kebutuhan > $saldo->jumlah) {
                $stok = format_angka($saldo->jumlah);
                $kebutuhan = format_angka($kebutuhan);
                $msg = "Pre Mixing Gagal Dibuat, Stok $namaBahan sisa $stok $namaSatuan, tidak dapat memenuhi kebutuhan sebanyak $kebutuhan $namaSatuan!";
                return $msg;
            }
        }
        return null;
    }

    public function validateBahanPakanKeluar($bahanPakanId, $bahanPakanKeluarId)
    {
        $saldo = app(BahanPakanInventoryRepository::class)
            ->setContext('bahan_pakan_keluar_id', [$bahanPakanKeluarId])
            ->findByBahanPakanId($bahanPakanId);
        dd($saldo);
        // $msg = "Bahan Pakan Gagal Dikeluarkan, Stok $namaBahan sisa $stok $namaSatuan, tidak dapat memenuhi kebutuhan sebanyak $kebutuhan $namaSatuan!";
    }
}