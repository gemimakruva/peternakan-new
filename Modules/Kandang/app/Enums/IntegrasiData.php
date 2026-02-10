<?php

namespace Modules\Kandang\Enums;

use App\Traits\BaseEnum;

/**
 * Untuk hitung kebutuhan treatment,
 * eg: dosis: 1 gram/kg pakan, untuk ambil berapa kg kebutuhan pakan hari itu
 */
enum IntegrasiData : string
{
    use BaseEnum;

    case FEED_INTAKE    = 'feed_intake';
    case WATER_INTAKE   = 'water_intake';
    case AYAM_SEHAT     = 'ayam_sehat';
    case BERAT_AYAM     = 'berat_ayam';

    public function title()
    {
        return match ($this->value) {
            self::FEED_INTAKE->value    => 'Feed Intake',
            self::WATER_INTAKE->value   => 'Water Intake',
            self::AYAM_SEHAT->value     => 'Ayam Sehat',
            self::BERAT_AYAM->value     => 'Berat Ayam',
            default => '',
        };
    }
}