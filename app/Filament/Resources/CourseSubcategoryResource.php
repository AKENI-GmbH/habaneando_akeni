<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseSubcategoryResource\Pages;
use App\Filament\Resources\CourseSubcategoryResource\RelationManagers\PlanRelationManager;
use App\Models\CourseCategory;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use App\Models\CourseSubcategory;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;

class CourseSubcategoryResource extends Resource
{
    protected static ?string $model = CourseSubcategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Course Level';

    protected static ?string $navigationGroup = 'Habaneando';


    public static function getModelLabel(): string
    {
        return __('Course Levels');
    }


    public static function getNavigationParentItem(): string
    {
        return __('Courses');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make(__('Details'))
                        ->schema([
                            TextInput::make('name')
                                ->columnSpan(2),
                            Select::make('category_id')
                                ->relationship('category', 'name'),
                            TextInput::make('amount'),
                        ])
                        ->columns(2),
                    Section::make(__('Settings'))
                        ->schema([
                            Toggle::make('is_club'),
                            Toggle::make('status'),
                        ])
                        ->grow(false)
                ]),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->sortable(),
                IconColumn::make('is_club')
                    ->boolean()
                    ->label(__('Club'))

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
            PlanRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseSubcategories::route('/'),
            'create' => Pages\CreateCourseSubcategory::route('/create'),
            'edit' => Pages\EditCourseSubcategory::route('/{record}/edit'),
        ];
    }
}
