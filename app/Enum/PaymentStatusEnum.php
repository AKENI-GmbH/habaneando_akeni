<?php

namespace App\Enum;

enum PaymentStatusEnum: string
{
    case ACCEPTED = 'Accepted';
    case PENDING = 'Pending';
    case DENIED = 'Denied';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => __($case->value)];
        })->toArray();
    }
}
