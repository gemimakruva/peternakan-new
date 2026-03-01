<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum TelurJenisTipe : string
{
    use BaseEnum;

    case MASUK      = 'masuk';
    case KELUAR     = 'keluar';
    case GRADING    = 'grading';
    case OPNAME     = 'opname';

    public function title()
    {
        return match ($this->value) {
            self::MASUK->value      => 'Masuk',
            self::KELUAR->value     => 'Keluar',
            self::GRADING->value    => 'Grading',
            self::OPNAME->value     => 'Opname',
            default => '',
        };
    }
}