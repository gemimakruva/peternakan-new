<?php

namespace App\Traits;

trait BaseEnum
{
    public static function getSelectItems(): array
    {
        return collect(self::cases())->map(function ($item) {
            return [
                'name'  => $item->title(),
                'value' => $item->value,
            ];
        })->pluck('name', 'value')->toArray();
    }

    public static function getArrayValues(): array
    {
        return collect(self::cases())->pluck('value')->toArray();
    }
}