<?php

namespace App\Filament\Resources\CourseResource\Pages;

use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Collection;
use App\Filament\Resources\CourseResource;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Mail;
use App\Models\CourseSubscription;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components;
use Filament\Actions\Action;
use Filament\Support\RawJs;
use Filament\Tables\Table;
use Jenssegers\Date\Date;
use Filament\Tables;
use App\Models;
use App\Enum;
use App\Filament\Resources\CourseResource\Widgets\CourseSubscriptionCount;
use App\Mail\CustomerNotification;

class ShowCourse extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    public ?Models\Course $record = null;

    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('New subscription')
                ->form([
                    Components\Select::make('customer_id')
                        ->label('Customer')
                        ->options(Models\Customer::all()->mapWithKeys(function ($customer) {
                            return [$customer->id => $customer->full_name];
                        })->all())
                        ->searchable()
                        ->required()
                        ->columnSpan(3),

                    Components\Select::make('subscriptionType')
                        ->required()
                        ->options(Enum\SubscriptionTypeEnum::toSelectArray()),

                    Components\Select::make('method')
                        ->label(__('Payment method'))
                        ->required()
                        ->options(Enum\PaymentMethodEnum::toSelectArray()),

                    Components\Select::make('payment_status')
                        ->label(__('Payment status'))
                        ->required()
                        ->options(Enum\PaymentStatusEnum::toSelectArray()),

                    Components\TextInput::make('amount')
                        ->mask(RawJs::make('$money($input)'))
                        ->inputMode('decimal'),

                    Components\DatePicker::make('created_at')
                        ->helperText(__('Optional'))
                        ->closeOnDateSelection()
                        ->native(false),

                    Components\DatePicker::make('valid_to')
                        ->helperText(__('Optional'))
                        ->closeOnDateSelection()
                        ->native(false),
                ])
                ->action(function (array $data): void {
                    $subscription = new CourseSubscription();
                    $subscription->fill($data);
                    $subscription->course()->associate($this->record);
                    $subscription->save();
                }),
            Action::make('edit')
                ->url(route('filament.admin.resources.courses.edit', ['record' => $this->record])),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CourseSubscriptionCount::class,
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return $this->record->name;
    }

    public function getSubheading(): ?string
    {
        return Date::parse($this->record->start_date)->format('l, j F Y');
    }


    protected function table(Table $table)
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('customer.first_name')->label(__('First name'))
                ->url(fn (CourseSubscription $record): string => route('filament.admin.resources.customers.edit', ['record' => $record->customer->id])),
            Tables\Columns\TextColumn::make('customer.last_name')->label(__('Last name'))
                ->url(fn (CourseSubscription $record): string => route('filament.admin.resources.customers.edit', ['record' => $record->customer->id])),
            Tables\Columns\TextColumn::make('created_at')->date('d-m-Y'),
            Tables\Columns\TextColumn::make('amount'),
            Tables\Columns\TextColumn::make('method'),
            Tables\Columns\TextColumn::make('payment_status'),
            Tables\Columns\IconColumn::make('is_active')
                ->label(__('Is active'))
                ->boolean()
                ->searchable(false),
        ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->query(CourseSubscription::query()->where('course_id', $this->record->id))
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make(__('Send notification'))
                        ->icon('heroicon-s-envelope')
                        ->form(function () {
                            return [
                                Components\TextInput::make('subject')->label(__('Subject')),
                                Components\TextArea::make('body')->label(__('Body'))
                                    ->rows(10)
                                    ->cols(20),
                            ];
                        })
                        ->action(
                            function (Collection $records, array $data) {
                                foreach ($records as $customer) {
                                    Mail::to('randy.duran@insimia.com')->send(new CustomerNotification($data['subject'], $data['body']));
                                }
                            }
                        )
                        ->slideOver(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static string $view = 'filament.resources.course-resource.pages.show-course';
}
