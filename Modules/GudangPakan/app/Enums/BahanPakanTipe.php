<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum BahanPakanTipe : string
{
    use BaseEnum;

    case PAKAN_PREMIX   = 'pakan_premix';
    case PAKAN_JADI     = 'pakan_jadi';

    public function title()
    {
        return match ($this->value) {
            self::PAKAN_PREMIX->value   => 'Pakan Premix',
            self::PAKAN_JADI->value     => 'Pakan Jadi',
            default => '',
        };
    }
}