<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RateCategoryResource\Pages;
use App\Filament\Resources\RateCategoryResource\RelationManagers\RatesRelationManager;
use App\Models\RateCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RateCategoryResource extends Resource
{
    protected static ?string $model = RateCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function getNavigationGroup(): ?string
    {
        return __('Pricing');
    }


    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Club Rates');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('position')
                    ->numeric()
                    ->required(),
                TextInput::make('duration')
                    ->numeric()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                IconColumn::make('status')
                    ->label(__(__('Status')))
                    ->boolean(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('duration')
                    ->tooltip(__('Months')),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            RatesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRateCategories::route('/'),
            'create' => Pages\CreateRateCategory::route('/create'),
            'edit' => Pages\EditRateCategory::route('/{record}/edit'),
        ];
    }
}
