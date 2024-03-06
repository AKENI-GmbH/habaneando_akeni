<?php

namespace App\Enum;

enum SubscriptionTypeEnum: string
{
    case MEMBERSHIP = 'Membership';
    case SINGLE_PAYMENT = 'Single Payment';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->value];
        })->toArray();
    }
}
