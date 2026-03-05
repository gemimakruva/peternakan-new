<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum BahanPakanMasukAsal : string
{
    use BaseEnum;

    case DARI_PEMBELIAN     = 'dari_pembelian';
    case DARI_PENGGILINGAN  = 'dari_penggilingan';
    case DARI_PREMIXING     = 'dari_premixing';
    case DARI_MIXING        = 'dari_mixing';

    public function title()
    {
        return match ($this->value) {
            self::DARI_PEMBELIAN->value     => 'Dari Pembelian',
            self::DARI_PENGGILINGAN->value  => 'Dari Penggilingan',
            self::DARI_PREMIXING->value     => 'Dari Premixing',
            self::DARI_MIXING->value        => 'Dari Mixing',
            default => '',
        };
    }
}