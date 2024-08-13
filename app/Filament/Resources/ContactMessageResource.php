<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use Filament\Tables\Actions\BulkAction;
use Filament\Resources\Resource;
use Filament\Forms\Components;
use App\Models\ContactMessage;
use Filament\Tables\Columns;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Habaneando';

    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string
    {
        return __('Messages');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Components\TextInput::make('name')->readonly(),
                Components\TextInput::make('email')->readonly(),
                Components\TextInput::make('subject')->readonly(),
                Components\Textarea::make('message')->readonly()
                    ->rows(10)
                    ->cols(20),
                Components\Select::make('read')
                    ->label('Mark as')
                    ->options([
                        1 => 'Read',
                        0 => 'Unread',
                    ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\IconColumn::make('read')
                    ->boolean(),
                Columns\TextColumn::make('name'),
                Columns\TextColumn::make('email'),
                Columns\TextColumn::make('created_at')
                    ->date('d-m-Y')
                    ->sortable()
            ])
            ->defaultSort('read', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    BulkAction::make('markAsRead')
                        ->label('Mark as Read')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['read' => true]);
                            });
                        }),
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
            'index' => Pages\ListContactMessages::route('/'),
            'create' => Pages\CreateContactMessage::route('/create'),
            'edit' => Pages\EditContactMessage::route('/{record}/edit'),
        ];
    }
}
