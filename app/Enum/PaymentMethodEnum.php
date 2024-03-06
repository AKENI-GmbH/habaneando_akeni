<?php

namespace App\Enum;

enum PaymentMethodEnum: string
{
    case SEPA = 'SEPA Mandat';
    case TRANSFER = 'SEPA Überweisung';
    case CREDITCARD = 'Credit Card';
    case CASH = 'Bar';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->value];
        })->toArray();
    }
}
