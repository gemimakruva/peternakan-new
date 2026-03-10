<?php

namespace Modules\GudangPakan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangPakan\Enums\BahanPakanTipe;
use Modules\GudangTelur\Models\Satuan;

class BahanPakanSeeder extends Seeder
{
    public function run(): void
    {
        $bahanPakan = [
            ['Jagung kuning giling', 5500],
            ['Dedak padi halus', 3200],
            ['Pollard (dedak gandum)', 3800],
            ['Onggok / gaplek', 2500],

            ['Bungkil kedelai (SBM)', 9200],
            ['Bungkil kelapa', 4500],
            ['Bungkil inti sawit', 3000],
            ['Tepung ikan', 12000],
            ['Meat bone meal', 7000],

            ['Tepung batu kapur (limestone)', 900],
            ['Tepung kerang', 1200],
            ['Dicalcium phosphate (DCP)', 15000],
        ];
        $satuanKg = app(Satuan::class)->firstOrCreate(['nama' => 'Kg']);
        foreach ($bahanPakan as [$nama, $harga]) {
            app(BahanPakan::class)->firstOrCreate([
                'satuan_id' => $satuanKg->id,
                'tipe'  => BahanPakanTipe::PAKAN_JADI->value,
                'nama'  => $nama,
                'harga' => $harga,
                'harga_satuan' => $harga,
            ]);
        }

        $bahanPremix = [
            ['Premix vitamin & mineral', 600000, 120],
            ['DL-Methionine', 2100000, 84],
            ['L-Lysine', 1750000, 70],
            ['Garam (NaCl)', 100000, 2],
            ['Toxin binder', 1500000, 60],
            ['Enzim (fitase, dll)', 150000, 150],
        ];
        $satuanGram = app(Satuan::class)->firstOrCreate(['nama' => 'Gram']);
        foreach ($bahanPremix as [$nama, $hargaKemasan, $hargaGram]) {
            app(BahanPakan::class)->firstOrCreate([
                'satuan_id' => $satuanGram->id,
                'tipe'  => BahanPakanTipe::PAKAN_PREMIX->value,
                'nama'  => $nama,
                'harga' => $hargaKemasan,
                'harga_satuan' => $hargaGram,
            ]);
        }
    }
}
