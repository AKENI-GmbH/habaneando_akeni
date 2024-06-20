<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Tabs;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Blog;
use Filament\Forms\Components;
use Filament\Tables;

class BlogResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([


                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Event'))
                            ->schema([
                                Components\Split::make([
                                    Components\Section::make([
                                        Components\TextInput::make('name'),
                                        Components\RichEditor::make('body'),
                                        Components\Textarea::make('short_text'),
                                    ]),
                                    Components\Section::make([
                                        Components\Toggle::make('status'),
                                    ])->grow(false),
                                ])
                            ]),
                        Tabs\Tab::make(__('Event Header'))
                            ->schema([
                                Components\Fieldset::make('')
                                    ->relationship('header')
                                    ->schema([
                                        Components\FileUpload::make('cover')->columnSpan(2),
                                        Components\Radio::make('mediaType')
                                            ->options([
                                                'image' => 'Image',
                                                'video' => 'Video',
                                            ])->inline()->default('image'),
                                        Components\TextInput::make('videoId'),
                                        Components\ColorPicker::make('overlayColor')->required()->default('#b51a00'),
                                        Components\ColorPicker::make('textColor')->required()->default('#fff'),
                                        Components\TextInput::make('overlayOpacity')->numeric()->default(50),
                                        Components\Toggle::make('overlay'),
                                        Components\Toggle::make('caption'),
                                    ])->columns(2)
                            ]),
                    ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('author.name')->searchable(false)->sortable(false),
                IconColumn::make('status')->boolean(),
                TextColumn::make('created_at')->date('d-m-Y'),
                TextColumn::make('updated_at')->date('d-m-Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ])
            ])->groupedBulkActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
                BulkAction::make('toggleStatus')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->status = !$record->status;
                            $record->save();
                        }
                    })->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Habaneando';

    protected static ?int $navigationSort = 8;
}
