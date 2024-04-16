<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use App\Models;
use Filament\Forms\Components;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use App\Enum;

class EventSubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'eventSubscriptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\Select::make('event_id')
                    ->label('Event')
                    ->required()
                    ->options(Models\Event::where('date_from', '>', now())->get()->mapWithKeys(function ($event) {
                        return [$event->id => "{$event->name} ({$event->date_from})"];
                    }))
                    ->getOptionLabelFromRecordUsing(fn ($event) => "{$event->name} ({$event->date_from})")
                    ->searchable()->columnSpan(2),

                Components\Select::make('ticket_id')
                    ->label('Ticket')
                    ->required()
                    ->options(Models\Ticket::all()->mapWithKeys(function ($ticket) {
                        return [$ticket->id => "{$ticket->ticketType->name} {$ticket->name} {$ticket->valid_date_from}-{$ticket->valid_date_until}"];
                    }))
                    ->getOptionLabelFromRecordUsing(fn ($ticket) => "{$ticket->name} ({$ticket->valid_date_from})")
                    ->searchable()->columnSpan(2),

                Components\TextInput::make('numberOfWomen')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->minValue(0),


                Components\TextInput::make('numberOfMen')
                    ->numeric()
                    ->required()
                    ->default(0)
                    ->minValue(0),


                Components\Select::make('method')
                    ->label(__('Payment method'))
                    ->required()
                    ->options(Enum\PaymentMethodEnum::toSelectArray()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('event.name')
            ->columns([
                Tables\Columns\TextColumn::make('event.name'),
                Tables\Columns\TextColumn::make('created_at'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
