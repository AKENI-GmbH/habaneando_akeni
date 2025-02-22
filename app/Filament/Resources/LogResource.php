<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogResource\Pages;
use App\Models\Log;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class LogResource extends Resource
{
    protected static ?string $model = Log::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('level')
                    ->required()
                    ->label('Level'),
                Textarea::make('message')
                    ->required()
                    ->rows(3)
                    ->label('Message'),
                Textarea::make('context')
                    ->label('Context (JSON)')
                    ->disabled(),
                TextInput::make('created_at')
                    ->label('Created At')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->label('ID'),
                TextColumn::make('level')
                    ->sortable()
                    ->label('Level'),
                TextColumn::make('message')
                    ->limit(50)
                    ->sortable()
                    ->label('Message'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
                // Optionally add filters here (e.g. filtering by level)
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            // Optionally define any relations here
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLogs::route('/'),
            'create' => Pages\CreateLog::route('/create'),
            'view'   => Pages\ViewLog::route('/{record}'),
            'edit'   => Pages\EditLog::route('/{record}/edit'),
        ];
    }
}