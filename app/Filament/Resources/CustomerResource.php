<?php

namespace App\Filament\Resources;


use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Mail\Newslatter;
use Filament\Resources\RelationManagers\RelationGroup;
use App\Filament\Resources\CustomerResource\Pages;
use Illuminate\Database\Eloquent\Collection;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Mail;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Tables\Filters\Filter;
use Filament\Resources\Resource;
use Filament\Actions\Action;
use Filament\Tables\Table;
use Filament\Forms\Form;
use App\Models\Customer;
use Filament\Tables\Columns;
use Filament\Tables;
use App\Services;

class CustomerResource extends Resource
{
    protected $mailjetEmailService;

    public function __construct(Services\MailjetEmailService $mailjetEmailService)
    {
        $this->mailjetEmailService = $mailjetEmailService;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make(__('Personal Details'))
                            ->schema([
                                TextInput::make('first_name')
                                    ->label(__('First name'))->required(),
                                TextInput::make('last_name')
                                    ->label(__('Last name'))->required(),
                                TextInput::make('email')
                                    ->label(__('Email'))->required()->type('email'),
                                TextInput::make('phone')
                                    ->label(__('Phone number')),

                                DatePicker::make('birthday')
                                    ->label(__('Birthday')),
                                Select::make('gender')
                                    ->label(__('Gender'))
                                    ->required()
                                    ->options([
                                        'Männlich' => 'Männlich',
                                        'Weiblich' => 'Weiblich',
                                        'Neutro' => 'Neutro',
                                    ]),
                                TextInput::make('profession')
                                    ->label(__('Profession')),

                                TextInput::make('IBAN')
                                    ->label(__('IBAN')),

                                TextInput::make('BIC')
                                    ->label(__('BIC'))
                            ])->columns(2),
                        Tabs\Tab::make(__('Address Details'))
                            ->schema([

                                TextInput::make('address')->label('Street'),
                                TextInput::make('address_aux')->label('Street 2'),
                                TextInput::make('city'),
                                TextInput::make('zip')->label('Postal Code'),

                            ]),
                        Tabs\Tab::make(__('Bank Details'))
                            ->schema([
                                TextInput::make('kontoinhaber')->label('Bank Account owner'),
                                TextInput::make('IBAN')->label('IBAN'),
                                TextInput::make('BIC')->label('BIC')
                            ]),
                    ]),


            ])->columns(1);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\TextColumn::make('first_name')
                    ->label(__('First name'))
                    ->sortable()
                    ->searchable(),

                Columns\TextColumn::make('last_name')
                    ->label(__('Last name'))
                    ->sortable()
                    ->searchable(),

                Columns\TextColumn::make('email')
                    ->label(__('Email address'))
                    ->sortable()
                    ->searchable(),

                Columns\TextColumn::make('profession')
                    ->label(__('Profession'))
                    ->sortable()
                    ->searchable(),

                Columns\TextColumn::make('birthday')
                    ->label(__('Birthday'))
                    ->sortable()
                    ->searchable(),

                Columns\TextColumn::make('clubMember.valid_date_until')
                    ->label(__('Membership'))
                    ->dateTime('d.m.Y')
                    ->placeholder(__('No Membership'))
                    ->sortable()->searchable(),

                Columns\TextColumn::make('clubMember.amount')

            ])
            ->filters([
                Filter::make('clubMember')
                    ->query(fn(Builder $query): Builder => $query->whereHas('clubMember'))

            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()->label('Edit Customer'),
                    Action::make(__('Send notification'))
                        ->icon('heroicon-s-envelope'),
                    Action::make(__('Edit Membership'))
                        ->icon('heroicon-m-identification')
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make(__('Send notification'))
                        ->icon('heroicon-s-envelope')
                        ->form(function () {
                            return [
                                TextInput::make('subject')->label(__('Subject')),
                                Textarea::make('body')->label(__('Body'))
                                    ->rows(10)
                                    ->cols(20),
                            ];
                        })
                        ->action(
                            function (Collection $records, array $data) {
                                foreach ($records as $customer) {
                                    Mail::to($customer)->send(new Newslatter($data['subject'], $data['body'], $customer));
                                }

                                \Filament\Notifications\Notification::make()
                                    ->title(__('Emails Sent'))
                                    ->body(__("Successfully sent emails to :count customers.", ['count' => $records->count()]))
                                    ->success()
                                    ->send();
                            }
                        )
                        ->slideOver(),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->selectCurrentPageOnly()
            ->persistSearchInSession()
            ->persistColumnSearchesInSession();
    }


    public static function getRelations(): array
    {
        return [
            RelationGroup::make(__('Courses'), [
                RelationManagers\CourseSubscriptionsRelationManager::class,
            ]),
            RelationGroup::make(__('Events'), [
                RelationManagers\EventSubscriptionsRelationManager::class,
            ]),
            RelationGroup::make(__('Membership'), [
                RelationManagers\ClubMemberRelationManager::class,
            ]),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['first_name', 'last_name', 'email', 'clubMember.membership_id'];
    }


    public static function getModelLabel(): string
    {
        return __('Customers');
    }

    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Habaneando';

    protected static ?string $recordTitleAttribute = 'full_name';

    protected static ?int $navigationSort = 3;
}
