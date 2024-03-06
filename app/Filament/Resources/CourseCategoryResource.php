<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseCategoryResource\RelationManagers\SubcategoriesRelationManager;
use App\Filament\Resources\CourseCategoryResource\Pages;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use App\Models\CourseCategory;
use Filament\Forms\Components\Section;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;

class CourseCategoryResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(__('Details'))
                    ->schema([
                        TextInput::make('name')->required(),
                        TextInput::make('description'),
                        Toggle::make('status'),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                IconColumn::make('status')->label(__('Status'))
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SubcategoriesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseCategories::route('/'),
            'create' => Pages\CreateCourseCategory::route('/create'),
            'edit' => Pages\EditCourseCategory::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = CourseCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Habaneando';

    public static function getModelLabel(): string
    {
        return __('Course Categories');
    }

    public static function getNavigationParentItem(): string
    {
        return __('Courses');
    }
}
