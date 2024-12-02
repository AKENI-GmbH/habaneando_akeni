<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TeacherResource\Pages;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Split;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Teacher;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;

class TeacherResource extends Resource
{

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        TextInput::make('first_name'),
                        TextInput::make('last_name'),
                        RichEditor::make('description')
                            ->columnSpan(2)
                            ->disableToolbarButtons([
                                'codeBlock',
                                'link',
                                'attachFiles',
                            ]),
                    ])->columns(2),
                    Section::make([
                        FileUpload::make('thumbnail')
                                            ->disk('spaces'),
                        TextInput::make('show_name')->label(__('Display as')),
                        TextInput::make('origin')->label(__('Origin')),
                        Toggle::make('is_staff'),
                    ])->grow(false),
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->width(100)
                    ->disk('spaces'),
                TextColumn::make('full_name')->label(__('Name')),
                IconColumn::make('is_staff')
                    ->label(__('Staff'))
                    ->boolean()
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
            'index' => Pages\ListTeachers::route('/'),
            'create' => Pages\CreateTeacher::route('/create'),
            'edit' => Pages\EditTeacher::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = Teacher::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }


    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'show_name'];
    }

    public static function getModelLabel(): string
    {
        return __('Teachers');
    }
}
