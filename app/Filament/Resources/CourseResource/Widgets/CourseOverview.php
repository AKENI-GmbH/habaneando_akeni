<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;

class CourseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Retrieve all courses and sum the number of subscriptions
        $currentSubscriptions = Course::withCount('subscriptions')->get();

        dd($currentSubscriptions);

        return [
            Stat::make(__('Current Subscriptions'), $currentSubscriptions),
        ];
    }
}
