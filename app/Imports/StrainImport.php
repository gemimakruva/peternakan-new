<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StrainImport implements WithMultipleSheets
{
    public function sheets() : array
    {
        return [
            'Lohmann' => new StrainSheetImport(),
            'Isa' => new StrainSheetImport(),
            'Hy-Line' => new StrainSheetImport(),
        ];
    }
}
