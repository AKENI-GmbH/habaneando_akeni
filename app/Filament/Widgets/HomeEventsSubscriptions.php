<?php

namespace App\Filament\Widgets;

use App\Models\EventSubscription;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;


class HomeEventsSubscriptions extends BaseWidget
{
    protected static ?string $heading = 'Events Subscriptions';

    public function table(Table $table): Table
    {

        return $table
            ->query($this->getQuery())
            ->columns([
                TextColumn::make('event.name')
                    ->label('Event')
                    ->url(fn (Eventsubscription $record) => route('filament.admin.resources.events.show', $record->event->slug)),
                TextColumn::make('customer.first_name')
                    ->label('Name')
                    ->url(fn (EventSubscription $record) => route('filament.admin.resources.customers.edit', $record->customer_id)),
                TextColumn::make('customer.last_name')
                    ->label('Last name')
                    ->url(fn (EventSubscription $record) => route('filament.admin.resources.customers.edit', $record->customer_id)),
                TextColumn::make('amount')
                    ->label('Amount'),
                TextColumn::make('fee')
                    ->label('Fee'),
                TextColumn::make('valid_to')
                    ->label('Valid To'),
            ])->defaultSort('created_at', 'desc');
    }

    protected function getQuery(): Builder
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return EventSubscription::query()->orderBy('created_at', 'desc')->take(20);
    }
}
