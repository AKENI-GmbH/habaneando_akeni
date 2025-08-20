<?php

namespace App\Enum;

enum EventTypeEnum: string
{
    case PARTY = 'Party';
    case WORKSHOP = 'Workshop';
    case CRASHCOURSE = 'Crashkurse';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->value];
        })->toArray();
    }
}
