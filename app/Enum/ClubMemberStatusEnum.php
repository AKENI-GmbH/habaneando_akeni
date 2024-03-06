<?php

namespace App\Enum;

enum ClubMemberStatusEnum: string
{
    case ACTIVE = 'Active';
    case PAUSED = 'Paused';
    case PENDING = 'Pending';
    case EXPIRED = 'Expired';

    public static function toSelectArray(): array
    {
        return collect(self::cases())->mapWithKeys(function ($case) {
            return [$case->value => $case->value];
        })->toArray();
    }
}
