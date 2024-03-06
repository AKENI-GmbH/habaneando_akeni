<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\RelationManagers;
use App\Filament\Resources\BlogResource\Pages;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Split;
use Illuminate\Support\Collection;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Blog;
use Filament\Tables;

class BlogResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Split::make([
                    Section::make([
                        TextInput::make('name'),
                        RichEditor::make('body'),
                        Textarea::make('short_text'),
                    ]),
                    Section::make([
                        Toggle::make('status'),
                        Placeholder::make('author')
                            ->content(fn (Blog $record) => $record->author->name)
                            ->visibleOn('edit'),
                        Placeholder::make('created_at')
                            ->content(fn (Blog $record) => $record->created_at->toFormattedDateString())
                            ->visibleOn('edit'),
                        Placeholder::make('updated_at')
                            ->content(fn (Blog $record) => $record->updated_at->toFormattedDateString())
                            ->visibleOn('edit'),
                    ])->grow(false),
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
