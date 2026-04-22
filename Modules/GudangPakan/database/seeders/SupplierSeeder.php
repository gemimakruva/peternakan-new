<?php

namespace Modules\GudangPakan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $this->generateSupplierBahanPakan(
            'Supri Selep',
            [
                'Jagung kuning giling',
                'Dedak padi halus',
                'Pollard (dedak gandum)',
                'Onggok / gaplek',
            ]
        );

        $this->generateSupplierBahanPakan(
            'Rudi Petani',
            [
                'Bungkil kedelai (SBM)',
                'Bungkil kelapa',
                'Bungkil inti sawit',
                'Tepung ikan',
                'Meat bone meal',
            ]
        );

        $this->generateSupplierBahanPakan(
            'Yanto Pedagang',
            [
                'Tepung batu kapur (limestone)',
                'Tepung kerang',
                'Dicalcium phosphate (DCP)',
            ]
        );
    }

    private function generateSupplierBahanPakan(string $nama, array $namaBahanPakan)
    {
        $supplier = Supplier::firstOrCreate([
            'tipe'  => SupplierTipe::BAHAN_PAKAN->value,
            'nama'  => $nama,
        ]);

        foreach ($namaBahanPakan as $item) {
            $bahanPakanId = app(BahanPakan::class)->where('nama', '=', $item)->value('id');
            $supplier->supplierBahanPakan()->create([
                'bahan_pakan_id' => $bahanPakanId,
            ]);
        }
    }
}
