<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum JenisPengiriman : string
{
    use BaseEnum;

    case LOCO   = 'loco';
    case FRANCO = 'franco';

    public function title()
    {
        return match ($this->value) {
            self::LOCO->value   => 'LOCO',
            self::FRANCO->value => 'FRANCO',
            default => '',
        };
    }
}