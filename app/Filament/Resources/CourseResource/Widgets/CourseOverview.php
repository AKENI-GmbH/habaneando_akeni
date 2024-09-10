<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use App\Filament\Resources\CourseResource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class CourseOverview extends BaseWidget
{

    public ?Course $course = null;
    protected function getStats(): array
    {
        $currentSubscriptions = $this->course ? $this->course->subscriptions()->count() : 0;

        return [
            Stat::make(__('Current Subscriptions'), $currentSubscriptions),
        ];
    }
}
