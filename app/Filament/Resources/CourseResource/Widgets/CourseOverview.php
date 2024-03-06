<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;

class CourseOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $course = Course::class;

        return [
            Stat::make(__('Active Courses'), $course::count()),
        ];
    }
}
