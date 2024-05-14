<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Jenssegers\Date\Date;

class EventStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $event = Event::class;
        $activeEventsCount = $event::where('status', true)
            ->where('date_to', '>', Date::now())
            ->count();

        $inactiveEventsCount = $event::where('status', false)->count();

        return [
            Stat::make(__('Active events'), $activeEventsCount)
                ->description("{$inactiveEventsCount} " . __('Inactive')),
        ];
    }
}
