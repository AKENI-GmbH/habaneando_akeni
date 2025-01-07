<?php

namespace App\Filament\Resources\CourseResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Course;

use Illuminate\Database\Eloquent\Model;

class CourseOverview extends BaseWidget
{
    public ?Model $record = null;

    protected function getStats(): array
    {

        $subscriptions = $this->record->subscriptions;

        $currentSubscriptions = $subscriptions->count();

        $women = $subscriptions->whereNotNull('numberOfWomen')->sum('numberOfWomen');
        $men = $subscriptions->whereNotNull('numberOfMen')->sum('numberOfMen');

        return [
            Stat::make(__('Current Subscriptions'), $currentSubscriptions),
            Stat::make(__('Women'), $women),
            Stat::make(__('Men'), $men),
        ];
    }
}
