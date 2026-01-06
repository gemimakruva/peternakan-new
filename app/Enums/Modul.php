<?php

namespace App\Enums;

enum Modul : string
{
    case SISTEM = 'sistem';
    case MASTER_DATA = 'master_data';
    case KANDANG = 'kandang';
    case GUDANG_PAKAN = 'gudang_pakan';
    case GUDANG_TELUR = 'gudang_telur';

    public function title()
    {
        return match ($this->value) {
            self::SISTEM->value => 'Sistem',
            self::MASTER_DATA->value => 'Master Data',
            self::KANDANG->value => 'Kandang',
            self::GUDANG_PAKAN->value => 'Gudang Pakan',
            self::GUDANG_TELUR->value => 'Gudang Telur',
            default => '',
        };
    }
}
