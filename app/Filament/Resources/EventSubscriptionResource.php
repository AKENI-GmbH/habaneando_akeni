<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventSubscriptionResource\Pages;

use App\Models\EventSubscription;
use Filament\Tables\Columns;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventSubscriptionResource extends Resource
{
    protected static ?string $model = EventSubscription::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('customer.full_name')
                    ->label(__('Customer'))
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('event.name')
                    ->label(__('Event'))
                    ->sortable()
                    ->searchable(),
                Columns\TextColumn::make('ticket.ticketType.name')
                    ->label(__('Ticket'))
                    ->sortable()
                    ->searchable(),
                    Columns\TextColumn::make('amount')
                    ->label(__('Total'))
                    ->sortable()
                    ->searchable(),
                    Columns\IconColumn::make('status')
                    ->boolean(),
                    Columns\TextColumn::make('created_at')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d.m.Y'))
                    ->sortable()
                    ->label(__('Boocked at')),
            ])
            ->filters([
                //
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventSubscriptions::route('/'),
            // 'create' => Pages\CreateEventSubscription::route('/create'),
            // 'edit' => Pages\EditEventSubscription::route('/{record}/edit'),
        ];
    }
}
