<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum BahanPakanKeluarTujuan : string
{
    use BaseEnum;

    case KE_PENJUALAN     = 'ke_penjualan';
    case KE_PENGGILINGAN  = 'ke_penggilingan';
    case KE_PREMIXING     = 'ke_premixing';
    case KE_MIXING        = 'ke_mixing';
    case KE_DISTRIBUSI    = 'ke_distribusi ';

    public function title()
    {
        return match ($this->value) {
            self::KE_PENJUALAN->value     => 'Ke Penjualan',
            self::KE_PENGGILINGAN->value  => 'Ke Penggilingan',
            self::KE_PREMIXING->value     => 'Ke Premixing',
            self::KE_MIXING->value        => 'Ke Mixing',
            self::KE_DISTRIBUSI->value    => 'Ke Distribusi',
            default => '',
        };
    }
}