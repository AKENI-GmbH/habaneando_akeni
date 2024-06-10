<?php

namespace App\Filament\Widgets;

use App\Enum\ClubMemberStatusEnum;
use App\Models\ClubMember;
use App\Models\CourseSubscription;
use App\Models\Customer;
use App\Models\EventSubscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;


class DashboardOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;


        $membersCount = ClubMember::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();
        $courseSubsCount = CourseSubscription::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();
        $eventSubsCount = EventSubscription::whereMonth('created_at', $currentMonth)->whereYear('created_at', $currentYear)->count();
        $currentMonthName = Carbon::now()->format('F');
        $birthdayCount = Customer::whereMonth('birthday', $currentMonth)->count();

        $montlyIncome = formatPriceGerman(ClubMember::where('status', ClubMemberStatusEnum::ACTIVE)
            ->orWhere('status', ClubMemberStatusEnum::PENDING)
            ->sum('amount'));

        return [
            Stat::make('New Members', $membersCount),
            Stat::make('Total Memberships', $montlyIncome . '€'),
            Stat::make('Course Subscriptions',  $courseSubsCount),
            Stat::make('Event Subscriptions', $eventSubsCount),
            Stat::make('New Messages', 1),
            Stat::make("{$currentMonthName}'s Birthdays", $birthdayCount),
        ];
    }
}
