<?php

namespace Modules\Kandang\Database\Seeders;

use App\Imports\StrainImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Kandang\Models\Strain;
use Modules\Kandang\Models\StrainStandartMetric;

class StrainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = Excel::import(new StrainImport(), base_path('/Modules/Kandang/database/seeders/database-strain-ayam.xlsx'));
        $datas = $datas->toCollection(new StrainImport(), base_path('/Modules/Kandang/database/seeders/database-strain-ayam.xlsx'));
        
        foreach ($datas->keys() as $strainName) {
            $strain = Strain::firstOrCreate(['nama' => $strainName]);

            $rows = $datas[$strainName]->skip(6);
            
            $rows->each(function($row) use($strain) {
                $strainMatrix = [
                    'strain_id' => $strain->id,
                    'umur' => $row[1],
                    'berat_badan_min' => $row[2],
                    'berat_badan_max' => $row[3],
                    'berat_badan' => $row[4],
                    'persentase_kematian' => $row[5],
                    'feed_intake' => $row[6],
                    'fcr' => $row[7],
                    'hdp' => $row[8],
                    'hhp' => $row[9],
                    'egg_weight' => $row[10],
                    'egg_mass' => $row[11],
                ];
                StrainStandartMetric::create($strainMatrix);
            });
        }
    }
}
