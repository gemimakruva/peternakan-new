<?php

namespace Modules\GudangPakan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangTelur\Enums\BahanPakanTipe;

class GudangPakanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanPakan = [
            'Jagung kuning giling',
            'Dedak padi halus',
            'Pollard (dedak gandum)',
            'Onggok / gaplek',

            'Bungkil kedelai (SBM)',
            'Bungkil kelapa',
            'Bungkil inti sawit',
            'Tepung ikan',
            'Meat bone meal',

            'Tepung batu kapur (limestone)',
            'Tepung kerang',
            'Dicalcium phosphate (DCP)',
        ];
        foreach ($bahanPakan as $nama) {
            app(BahanPakan::class)->firstOrCreate([
                'tipe'  => BahanPakanTipe::PAKAN_JADI->value,
                'nama'  => $nama,
            ]);
        }
        $bahanPremix = [
            'Premix vitamin & mineral',
            'DL-Methionine',
            'L-Lysine',
            'Garam (NaCl)',
            'Toxin binder',
            'Enzim (fitase, dll)',
        ];
        foreach ($bahanPremix as $nama) {
            app(BahanPakan::class)->firstOrCreate([
                'tipe'  => BahanPakanTipe::PAKAN_PREMIX->value,
                'nama'  => $nama,
            ]);
        }
    }
}
