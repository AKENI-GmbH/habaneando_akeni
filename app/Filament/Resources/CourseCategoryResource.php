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
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;

class CourseCategoryResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Course Category')
                            ->schema([
                                Section::make([
                                    TextInput::make('name')->required(),
                                    TextInput::make('description'),
                                    Toggle::make('status'),
                                ]),

                            ]),
                        Tabs\Tab::make(__('Page Header'))
                            ->schema([
                                Fieldset::make(__('Page header'))
                                    ->relationship('header')
                                    ->schema([
                                        FileUpload::make('cover')->columnSpan(2),
                                        Radio::make('mediaType')
                                            ->options([
                                                'image' => 'Image',
                                                'video' => 'Video',
                                            ])->inline()->required(),
                                        TextInput::make('videoId'),
                                        ColorPicker::make('overlayColor')->required(),
                                        ColorPicker::make('textColor')->required(),
                                        TextInput::make('overlayOpacity')->numeric()->required(),
                                        Toggle::make('overlay'),
                                        Toggle::make('caption'),
                                    ])->columns(2)->label(false),
                            ]),
                    ])




            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('header.cover')->width('100px'),
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
