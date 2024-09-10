<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Radio;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;
use App\Models\Page;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Columns\ImageColumn;



class PageResource extends Resource
{

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Page'))
                            ->schema([
                                Section::make([
                                    FileUpload::make('image'),
                                    TextInput::make('name'),
                                    RichEditor::make('body')
                                        ->toolbarButtons([
                                            'blockquote',
                                            'bold',
                                            'bulletList',
                                            'h2',
                                            'h3',
                                            'italic',
                                            'orderedList',
                                            'redo',
                                            'strike',
                                            'underline',
                                            'undo',
                                            'tables'
                                        ])
                                        ->disableToolbarButtons([
                                            'codeBlock',
                                            'attachFiles',
                                            'link',
                                        ]),
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
                                            ])->inline(),
                                        TextInput::make('videoId'),
                                        ColorPicker::make('overlayColor'),
                                        ColorPicker::make('textColor'),
                                        TextInput::make('overlayOpacity')->numeric(),
                                        Toggle::make('overlay'),
                                        Toggle::make('caption'),
                                    ])->columns(2)
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
                IconColumn::make('status')->boolean()
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
                Tables\Actions\BulkActionGroup::make([]),
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return __('Settings');
    }


    public static function getModelLabel(): string
    {
        return __('Pages');
    }
}
