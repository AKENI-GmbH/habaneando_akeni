<?php

namespace App\Filament\Resources\EventResource\Pages;

use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\EventResource;
use App\Mail\CustomerNotification;
use App\Mail\NotificationEmail;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\Page;
use App\Models\EventSubscription;
use Filament\Forms\Components;
use Filament\Actions\Action;
use Filament\Support\RawJs;
use Filament\Tables\Table;
use Jenssegers\Date\Date;
use Filament\Tables;
use App\Models;

class ShowEvent extends Page implements Tables\Contracts\HasTable
{

    use InteractsWithTable;

    public ?Models\Event $record = null;

    protected static string $resource = EventResource::class;


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
                    $subscription = new EventSubscription();
                    $subscription->fill($data);
                    $subscription->event()->associate($this->record);
                    $subscription->save();
                }),
            // Action::make('edit')
            //     ->url(route('filament.admin.resources.event-subscriptions.edit', $this->record)),
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
                ->url(fn (EventSubscription $record): string => route('filament.admin.resources.customers.edit', ['record' => $record->customer->id])),
            Tables\Columns\TextColumn::make('customer.last_name')->label(__('Last name'))
                ->url(fn (EventSubscription $record): string => route('filament.admin.resources.customers.edit', ['record' => $record->customer->id])),
            Tables\Columns\TextColumn::make('created_at')->date('d-m-Y'),
            Tables\Columns\TextColumn::make('amount'),
            Tables\Columns\TextColumn::make('method'),
            Tables\Columns\IconColumn::make('status')
                ->boolean()
                ->searchable(false),
        ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->query(EventSubscription::query()->where('event_id', $this->record->id))
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
                                dd($records);
                                foreach ($records as $customer) {
                                    dd($records);
                                    Mail::to($customer->email)->send(new NotificationEmail($data['subject'], $data['body']));
                                }
                            }
                        )
                        ->slideOver(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static string $view = 'filament.resources.event-resource.pages.show-event';
}
