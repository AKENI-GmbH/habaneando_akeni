<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Enum\SubscriptionTypeEnum;
use App\Enum\PaymentMethodEnum;
use App\Enum\PaymentStatusEnum;
use App\Models\Course;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\DatePicker;
use Jenssegers\Date\Date;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class CourseSubscriptionsRelationManager extends RelationManager
{
    protected static string $relationship = 'courseSubscriptions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Select::make('course_id')
                    ->label('Course')
                    ->options(function () {

                        return Course::whereHas('subcategory', function ($query) {
                            $query->where('is_club', true);
                        })
                            ->where('start_date', '>=', now())
                            ->get()
                            ->mapWithKeys(function ($course) {
                                $date = Date::parse($course->start_date)->format('l');
                                return [$course->id => "{$course->name}, {$date}, {$course->primaryTeacher->first_name} {$course->primaryTeacher->last_name}"];
                            });
                    })
                    ->getOptionLabelFromRecordUsing(function ($course) {
                        return "{$course->name} (" . Date::parse($course->start_date)->format('l, j F Y') . ")";
                    })
                    ->searchable()
                    ->columnSpan(2),

                Select::make('subscriptionType')
                    ->required()
                    ->options(SubscriptionTypeEnum::toSelectArray()),


                Select::make('method')
                    ->label(__('Payment method'))
                    ->required()
                    ->options(PaymentMethodEnum::toSelectArray()),


                TextInput::make('amount')
                    ->label(__('Price'))
                    ->numeric()
                    ->prefix('€')
                    ->required()
                    ->maxValue(42949672.95),


                Select::make('payment_status')
                    ->label(__('Payment status'))
                    ->required()
                    ->options(PaymentStatusEnum::toSelectArray()),


                DatePicker::make('created_at')
                    ->native(false),


                DatePicker::make('valid_to')
                    ->native(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('course.name')
            ->columns([
                TextColumn::make('course.name'),
                TextColumn::make('created_at')->date('d-m-Y'),
                TextColumn::make('amount'),
                TextColumn::make('method'),
                TextColumn::make('payment_status'),
                IconColumn::make('is_active')
                    ->label(__('Is active'))
                    ->boolean(),

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
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
