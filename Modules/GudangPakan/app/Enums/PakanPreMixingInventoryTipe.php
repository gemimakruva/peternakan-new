<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum PakanPreMixingInventoryTipe : string
{
    use BaseEnum;

    case MASUK  = 'masuk';
    case KELUAR = 'keluar';

    public function title()
    {
        return match ($this->value) {
            self::MASUK->value  => 'Masuk',
            self::KELUAR->value => 'Keluar',
            default => '',
        };
    }
}