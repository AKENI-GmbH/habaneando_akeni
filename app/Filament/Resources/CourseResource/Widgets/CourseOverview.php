<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;

class CourseOverview extends BaseWidget
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
