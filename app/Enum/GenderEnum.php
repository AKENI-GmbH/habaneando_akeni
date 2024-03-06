<?php

namespace App\Enum;

enum GenderEnum: string
{
    case MALE = 'Männlich';
    case FEMALE = 'Weiblich';
    case NEUTRO = 'Neutro';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->value];
        })->toArray();
    }
}
