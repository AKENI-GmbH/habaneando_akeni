<?php

namespace App\Filament\Resources;

use App\Enum\EventTypeEnum;
use App\Filament\Resources\EventResource\RelationManagers\TeachersRelationManager;
use App\Filament\Resources\EventResource\Pages;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Event;
use Filament\Forms\Components\KeyValue;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;

class EventResource extends Resource
{
    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make([
                    TextInput::make('name')->label(__('Event name')),

                    Select::make('event_type')
                        ->options(EventTypeEnum::toSelectArray())
                        ->helperText(__('This option affects where on your page this event will be visible.')),

                    Section::make([
                        Select::make('location_id')->relationship('location', 'name'),
                        Select::make('ticket_type_id')->label(__('Ticket Group'))->relationship('ticketType', 'name')
                            ->helperText(__('This option affects where on your page this event will be visible.')),

                    ])->columns(2),

                    Section::make([
                        DatePicker::make('date_from')->required()->native(false),
                        DatePicker::make('date_to')->required()->native(false),
                        TimePicker::make('time_from')->seconds(false),
                        TimePicker::make('time_to')->seconds(false),
                    ])->columns(4),

                    Tabs::make('Tabs')
                        ->tabs([
                            Tabs\Tab::make('Description')
                                ->schema([
                                    RichEditor::make('description')->disableToolbarButtons([
                                        'codeBlock',
                                        'attachFiles',
                                    ]),
                                ]),
                            Tabs\Tab::make('AGB')
                                ->schema([
                                    RichEditor::make('conditions')->disableToolbarButtons([
                                        'codeBlock',
                                        'attachFiles',
                                    ]),
                                ]),
                            Tabs\Tab::make(__('Programm'))
                                ->schema([
                                    RichEditor::make('program')->disableToolbarButtons([
                                        'codeBlock',
                                        'attachFiles',
                                    ]),
                                ]),
                            Tabs\Tab::make(__('Accomodation'))
                                ->schema([
                                    RichEditor::make('accomodation')->disableToolbarButtons([
                                        'codeBlock',
                                        'attachFiles',
                                    ]),
                                ]),
                        ]),
                ]),
                Section::make([
                    FileUpload::make('thumbnail')
                        ->image()
                        ->disk('spaces')
                        ->directory('form-attachments')
                        ->visibility('public')
                        ->rules(['required', 'image', 'max:10240']),

                    Section::make([
                        Toggle::make('status'),
                        Toggle::make('bookable')
                            ->label(__('Bookable')),
                        Toggle::make('onlyDoor')
                            ->label(__('Pay at door')),
                        Toggle::make('event.soldOut')
                            ->label(__('Sold Out')),
                        Toggle::make('ladiesOnly')
                            ->label(__('Ladies Only')),

                    ])->columns(5),

                    KeyValue::make('extras'),
                ])->grow(false),

            ])->columns(1);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('date_to', '>=', now());
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('date_from')->date('d-m-Y')->sortable(),
                TextColumn::make('date_to')->date('d-m-Y')->sortable(),
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
            ->groupedBulkActions([
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
            ])
            ->selectCurrentPageOnly();
    }

    public static function getRelations(): array
    {
        return [
            TeachersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Habaneando';

    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('Events');
    }
}
