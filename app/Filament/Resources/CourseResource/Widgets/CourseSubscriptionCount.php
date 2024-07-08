<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Models\Course;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CourseSubscriptionCount extends BaseWidget
{
    protected function getStats(): array
    {
        $activeCourses = Course::where('start_date', '>=', now())->get();

        $activeCoursesCount = $activeCourses->count();
        $currentSubscriptions = 0;

        foreach ($activeCourses as $course) {
            $currentSubscriptions += $course->subscriptions()->count();
        }

        return [
            Stat::make(__('Active Courses'), $activeCoursesCount),
            Stat::make(__('Current Subscriptions'), $currentSubscriptions),
        ];
    }
}
