<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum PakanFinishedGoodInventoryTipe : string
{
    use BaseEnum;

    case MASUK  = 'masuk';
    case KELUAR = 'keluar';
    case OPNAME = 'opname';

    public function title()
    {
        return match ($this->value) {
            self::MASUK->value  => 'Masuk',
            self::KELUAR->value => 'Keluar',
            self::OPNAME->value => 'Opname',
            default => '',
        };
    }
}