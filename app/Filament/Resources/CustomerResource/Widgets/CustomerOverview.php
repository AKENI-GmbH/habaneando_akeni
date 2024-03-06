<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Enum\ClubMemberStatusEnum;
use App\Enum\GenderEnum;
use App\Models\ClubMember;
use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CustomerOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $customer = Customer::class;
        $montlyIncome = formatPriceGerman(ClubMember::where('status', ClubMemberStatusEnum::ACTIVE)
        ->orWhere('status', ClubMemberStatusEnum::PENDING)
        ->sum('amount'));

        $totalMen = $customer::where('gender', GenderEnum::MALE)->count();
        $totalWomen = $customer::where('gender', GenderEnum::FEMALE)->count();
        $women = __('women');
        $men = __('men');
        
        return [
            Stat::make(__('Registered'), $customer::count())
            ->color('white')
            ->description("{$totalWomen} {$women} · {$totalMen} {$men}"),
            Stat::make(__('Active memberships'), $customer::whereHas('clubMember')->count()),
            Stat::make(__('Monthly Membership'), $montlyIncome),
        ];
    }
}
