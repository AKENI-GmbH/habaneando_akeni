<?php

namespace App\Filament\Resources\CourseCategoryResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Split;
use Filament\Support\RawJs;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;

class SubcategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'subcategories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('amount')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Textarea::make('description')
                    ->maxLength(255),
                Split::make([
                    Toggle::make('status'),
                    Toggle::make('is_club'),
                ])
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('price')
                ->placeholder(__('Club Rate')),
                IconColumn::make('is_club')->label(__('Club'))->boolean(),
                IconColumn::make('status')->label(__('Status'))->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

}
