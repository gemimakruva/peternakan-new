<?php

namespace Modules\GudangPakan\Enums;

use App\Traits\BaseEnum;

enum BahanPakanMasukAsal : string
{
    use BaseEnum;

    case DARI_PEMBELIAN     = 'dari_pembelian'; // auto-input from pembelian menu
    case DARI_PENGGILINGAN  = 'dari_penggilingan';
    case DARI_PREMIXING     = 'dari_premixing'; // auto-input from premixing menu
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

    public static function getSelectItems2()
    {
        return [
            self::DARI_PENGGILINGAN->value  => self::DARI_PENGGILINGAN->title(),
            self::DARI_PREMIXING->value     => self::DARI_PREMIXING->title(),
            self::DARI_MIXING->value        => self::DARI_MIXING->title(),
        ];
    }
}