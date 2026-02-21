<?php

namespace Modules\Kandang\Enums;

use App\Traits\BaseEnum;

enum CatatanLaporanTipe : string
{
    use BaseEnum;

    case MINGGUAN_PER_KANDANG   = 'mingguan_per_kandang';
    case MINGGUAN_PER_FLOCK     = 'mingguan_per_flock';
    case HARIAN_PER_KANDANG     = 'harian_per_kandang';
    case HARIAN_PER_FLOCK       = 'harian_per_flock';

    public function title()
    {
        return match ($this->value) {
            self::MINGGUAN_PER_KANDANG->value   => 'Mingguan per Kandang',
            self::MINGGUAN_PER_FLOCK->value     => 'Mingguan per Flock',
            self::HARIAN_PER_KANDANG->value     => 'Harian per Kandang',
            self::HARIAN_PER_FLOCK->value       => 'Harian per Flock',
            default => '',
        };
    }
}