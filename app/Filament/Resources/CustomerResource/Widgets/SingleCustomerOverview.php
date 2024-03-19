<?php

namespace App\Filament\Resources\CustomerResource\Widgets;

use App\Models\Customer;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SingleCustomerOverview extends BaseWidget
{

    public ?Customer $record = null;


    protected function getStats(): array
    {
        $customer = $this->record;

        return [
            Stat::make(__('Active Courses'), $customer->courseSubscriptions()->where('valid_to', '>', Now())->count())
        ];
    }
}
