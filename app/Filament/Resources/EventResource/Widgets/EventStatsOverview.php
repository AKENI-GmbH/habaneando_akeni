<?php

namespace App\Filament\Resources\EventResource\Widgets;

use App\Models\Event;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class EventStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $event = Event::class;
        $inactive = __('Inactive');

        return [
            Stat::make(__('Active events'), $event::where('status', true)->count())
            ->description("{$event::where('status', false)->count()} {$inactive}"),
        ];
    }
}
