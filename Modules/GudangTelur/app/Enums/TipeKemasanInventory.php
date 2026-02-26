<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum TipeKemasanInventory : string
{
    use BaseEnum;

    case INPUT  = 'input';
    case OUTPUT = 'output';
    case OPNAME = 'opname';

    public function title()
    {
        return match ($this->value) {
            self::INPUT->value  => 'Input',
            self::OUTPUT->value => 'Output',
            self::OPNAME->value => 'Opname',
            default => '',
        };
    }
}