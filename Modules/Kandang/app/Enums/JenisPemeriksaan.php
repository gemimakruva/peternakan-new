<?php

namespace Modules\Kandang\Enums;

enum JenisPemeriksaan : string
{
    case PENGADAAN = 'pengadaan';
    case HARIAN = 'harian';
    case CEK_KESEHATAN = 'cek_kesehatan';

    public function title()
    {
        return match ($this->value) {
            self::PENGADAAN->value => 'Pengadaan',
            self::HARIAN->value => 'Harian',
            self::CEK_KESEHATAN->value => 'Cek Kesehatan',
            default => '',
        };
    }
}