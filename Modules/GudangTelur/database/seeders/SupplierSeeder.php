<?php

namespace Modules\GudangTelur\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\GudangTelur\Enums\SupplierTipe;
use Modules\GudangTelur\Models\Kemasan;
use Modules\GudangTelur\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            ['satuan_id' => 4, 'nama' => 'Tray Carton'],
            ['satuan_id' => 4, 'nama' => 'Pack isi 10'],
            ['satuan_id' => 4, 'nama' => 'Pack isi 6'],
            ['satuan_id' => 4, 'nama' => 'Peti'],
        ];
        foreach ($datas as $data) {
            Kemasan::firstOrCreate($data);
        }

        $datas = [];
        for ($i=0; $i < 11; $i++) { 
            $company = fake()->company();
            $address = fake()->address();
            $datas[] = [
                'tipe'          => SupplierTipe::KEMASAN->value,
                'nama'          => $company,
                'badan_usaha'   => $company,
                'kontak'        => fake()->numerify("+628##########"),
                'alamat'        => $address,
                'lokasi'        => $address,
            ];
        }
        Supplier::insert($datas);
    }
}
