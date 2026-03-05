<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum BahanPakanFormulasiTipe : string
{
    use BaseEnum;

    case PRE_MIXING = 'pre_mixing';
    case MIXING     = 'mixing';

    public function title()
    {
        return match ($this->value) {
            self::PRE_MIXING->value => 'Pre Mixing',
            self::MIXING->value     => 'Mixing',
            default => '',
        };
    }
}