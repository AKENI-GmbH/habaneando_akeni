<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns;
use App\Models\CourseSubcategory;
use Filament\Resources\Resource;
use App\Models\CourseCategory;
use Filament\Tables\Table;
use App\Models\Location;
use Filament\Forms\Form;
use App\Models\Course;
use App\Models\Teacher;
use Filament\Tables;

class CourseResource extends Resource
{
    public static function form(Form $form): Form
    {;
        $days = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag', 'Sonntag'];

        return $form
            ->schema([
                \Filament\Forms\Components\Section::make(__('Course details'))
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('name')
                            ->required()
                            ->columnSpan(4),

                        \Filament\Forms\Components\Select::make('teacher1_id')
                            ->options(Teacher::all()->mapWithKeys(function ($teacher) {
                                return [$teacher->id => $teacher->full_name];
                            }))
                            ->required()
                            ->label(__('Instructor'))
                            ->columnSpan(2),

                        \Filament\Forms\Components\Select::make('teacher2_id')
                            ->options(Teacher::all()->mapWithKeys(function ($teacher) {
                                return [$teacher->id => $teacher->full_name];
                            }))
                            ->label(__('Instructor'))
                            ->columnSpan(2),

                        \Filament\Forms\Components\Select::make('location_id')
                            ->required()
                            ->label(__('Location'))
                            ->options(Location::query()->pluck('name', 'id')->all())
                            ->columnSpan(2),

                        \Filament\Forms\Components\Select::make('subcategory_id')
                            ->required()
                            ->options(CourseSubcategory::all()->mapWithKeys(function ($subcategory) {
                                return [$subcategory->id => $subcategory->level];
                            })->all())->label(__('Course level'))
                            ->columnSpan(2),


                    ])->columns(4),


                \Filament\Forms\Components\Section::make(__('Date details'))
                    ->schema([
                        \Filament\Forms\Components\Select::make('schedule_day')->options(array_combine($days, $days))
                            ->required()
                            ->label(__('Day of the Week'))
                            ->columnSpan(4),

                        \Filament\Forms\Components\DatePicker::make('start_date')
                            ->required()
                            ->label(__('Start Date'))
                            ->native(false)
                            ->columnSpan(1),

                        \Filament\Forms\Components\DatePicker::make('end_date')
                            ->label(__('End Date'))
                            ->native(false)
                            ->columnSpan(1),

                        \Filament\Forms\Components\TimePicker::make('schedule_time_from')
                            ->required()
                            ->label(__('Start Time'))
                            ->columnSpan(1),

                        \Filament\Forms\Components\TimePicker::make('schedule_time_to')
                            ->required()
                            ->label(__('End Time'))
                            ->columnSpan(1),
                    ])->columns(4),


                \Filament\Forms\Components\Section::make(__('Content'))
                    ->schema([
                        \Filament\Forms\Components\RichEditor::make('description')
                            ->label(false)
                            ->disableToolbarButtons([
                                'codeBlock',
                                'attachFiles',
                                'link',
                            ])
                    ]),

                \Filament\Forms\Components\Section::make(__('Settings'))
                    ->schema([
                        \Filament\Forms\Components\Toggle::make('status')
                            ->label(__('Status')),
                        \Filament\Forms\Components\Toggle::make('endless')
                            ->label(__('Endless')),
                        \Filament\Forms\Components\Toggle::make('bookable')
                            ->label(__('Bookable')),
                        \Filament\Forms\Components\Toggle::make('allowsinglePayment')
                            ->label(__('Single Payment')),
                        \Filament\Forms\Components\Toggle::make('soldout')
                            ->label(__('Soldout')),
                    ])->columns(5),
            ])->columns();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('course_id')
                    ->url(fn(Course $record): string => route('filament.admin.resources.courses.show', ['record' => $record])),
                Columns\TextColumn::make('name')
                    ->url(fn(Course $record): string => route('filament.admin.resources.courses.show', ['record' => $record])),
                Columns\TextColumn::make('subcategory.level')
                    ->searchable(false)
                    ->label('Level'),
                Columns\IconColumn::make('subcategory.is_club')
                    ->label(__('Club'))
                    ->boolean(),
                Columns\TextColumn::make('subcategory.price')
                    ->label(__('Price'))
                    ->placeholder(__('Club'))
                    ->sortable(false)
                    ->searchable(false),

                Columns\TextColumn::make('start_date')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d.m.Y'))
                    ->sortable()
                    ->placeholder(__('Empty'))
                    ->label(__('Starts at')),

                Columns\TextColumn::make('end_date')
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->format('d.m.Y'))
                    ->sortable()
                    ->placeholder(__('Empty'))
                    ->label(__('Ends at')),


                Columns\IconColumn::make('status')->label(__('Status'))->boolean(),
            ])->defaultSort('start_date', 'asc')
            ->filters([
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->options(fn() => CourseCategory::pluck('name', 'id')->toArray())
                    ->label(__('Course Categories'))
                    ->query(function (Builder $query, array $state) {
                        if ($state['value']) {
                            $query->whereHas('subcategory', function ($subQuery) use ($state) {
                                $subQuery->where('category_id', $state);
                            });
                        }
                    })->searchable(),


                \Filament\Tables\Filters\Filter::make('start_date')
                    ->label(__('Start Date'))
                    ->query(function (Builder $query, array $state) {
                        if (isset($state['value'])) {
                            $query->whereDate('start_date', $state['value']);
                        }
                    })
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('value')
                            ->label(__('Start Date'))
                            ->placeholder(__('Select a date')),
                    ]),


                \Filament\Tables\Filters\Filter::make('is_club')
                    ->label(__('Only club'))

                    ->query(function (Builder $query, array $state) {
                        if (isset($state['isActive'])) {
                            $query->whereHas('subcategory', function ($subQuery) use ($state) {
                                $subQuery->where('is_club', $state);
                            });
                        }
                    })->toggle(),

            ])->hiddenFilterIndicators()
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->groupedBulkActions([
                \Filament\Tables\Actions\BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
                \Filament\Tables\Actions\BulkAction::make('toggleStatus')
                    ->requiresConfirmation()
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->status = !$record->status;
                            $record->save();
                        }
                    })->deselectRecordsAfterCompletion(),
            ])->defaultSort('created_at', 'desc')
            ->selectCurrentPageOnly();
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
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'show' => Pages\ShowCourse::route('/{record}/show'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }

    protected static ?string $model = Course::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getGloballySearchableAttributes(): array
    {
        return ['course_id', 'name', 'location.name', 'subcategory.name', 'subcategory.category.name'];
    }

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Habaneando';

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('Courses');
    }
}
