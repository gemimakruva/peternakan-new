<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DataAyamImport implements WithMultipleSheets
{
    public function sheets() : array
    {
        return [
            'populasi_ayam' => new BaseImport(),
            'pakan' => new BaseImport(),
            'telur' => new BaseImport(),
        ];
    }
}
