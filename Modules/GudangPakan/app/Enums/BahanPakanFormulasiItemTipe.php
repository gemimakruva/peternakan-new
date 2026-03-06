<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum BahanPakanFormulasiItemTipe : string
{
    use BaseEnum;

    case PREMIX = 'premix';
    case RAW    = 'raw';

    public function title()
    {
        return match ($this->value) {
            self::PREMIX->value => 'Premix',
            self::RAW->value    => 'Raw',
            default => '',
        };
    }
}