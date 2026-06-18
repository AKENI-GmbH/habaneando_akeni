<?php

namespace App\Filament\Widgets;

use App\Enum\ClubMemberStatusEnum;
use App\Models\ClubMember;
use App\Models\CourseSubscription;
use App\Models\Customer;
use App\Models\EventSubscription;
use App\Models\ContactMessage;
use App\Filament\Resources\ContactMessageResource;
use App\Filament\Resources\CourseResource;
use App\Filament\Resources\CustomerResource;
use App\Filament\Resources\EventSubscriptionResource;
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

        $messages = ContactMessage::where('read', false)->count();

        return [
            Stat::make('New Members', $membersCount)->url(CustomerResource::getUrl('index')),
            Stat::make('Total Memberships', $montlyIncome . '€')->url(CustomerResource::getUrl('index')),
            Stat::make('Course Subscriptions',  $courseSubsCount)->url(CourseResource::getUrl('index')),
            Stat::make('Event Subscriptions', $eventSubsCount)->url(EventSubscriptionResource::getUrl('index')),
            Stat::make('New Messages', $messages)->url(ContactMessageResource::getUrl('index')),
            Stat::make("{$currentMonthName}'s Birthdays", $birthdayCount)->url(CustomerResource::getUrl('index')),
        ];
    }
}
