<?php

namespace Modules\GudangTelur\Enums;

use App\Traits\BaseEnum;

enum SupplierTipe : string
{
    use BaseEnum;

    case KEMASAN        = 'kemasan';
    case BAHAN_PAKAN    = 'bahan_pakan';

    public function title()
    {
        return match ($this->value) {
            self::KEMASAN->value        => 'Kemasan',
            self::BAHAN_PAKAN->value    => 'Bahan Pakan',
            default => '',
        };
    }
}