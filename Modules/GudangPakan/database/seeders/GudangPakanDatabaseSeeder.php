<?php

namespace Modules\GudangPakan\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangPakan\Models\BahanBaku;
use Modules\GudangTelur\Enums\BahanBakuTipe;

class GudangPakanDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bahanBaku = [
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
        foreach ($bahanBaku as $nama) {
            app(BahanBaku::class)->firstOrCreate([
                'tipe'  => BahanBakuTipe::PAKAN_JADI->value,
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
            app(BahanBaku::class)->firstOrCreate([
                'tipe'  => BahanBakuTipe::PAKAN_PREMIX->value,
                'nama'  => $nama,
            ]);
        }
    }
}
