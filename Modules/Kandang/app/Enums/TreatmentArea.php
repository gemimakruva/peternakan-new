<?php

namespace Modules\Kandang\Enums;

enum TreatmentArea : string
{
    case BAWAH_KANDANG  = 'bawah_kandang';
    case KOTORAN_AYAM   = 'kotoran_ayam';

    public function title()
    {
        return match ($this->value) {
            self::BAWAH_KANDANG->value => 'Bawah Kandang',
            self::KOTORAN_AYAM->value => 'Kotoran Ayam',
            default => '',
        };
    }
}