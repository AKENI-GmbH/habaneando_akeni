<?php

namespace App\Filament\Resources\CustomerResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\Select;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Tables;


class ClubMemberRelationManager extends RelationManager
{
    protected static string $relationship = 'clubMember';

    protected static bool $canCreateAnother = false;

    public function create(array $data)
    {
        $clubMember = parent::create($data);

        $membershipId = $clubMember->customer_id . $clubMember->club_rate_id . now()->format('ymd');

        $clubMember->update(['membership_id' => $membershipId]);

        return $clubMember;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('club_rate_id')
                    ->label(__('Club Rate'))
                    ->required()
                    ->relationship(
                        name: 'ClubRate',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('rate_category_id'),
                    )
                    ->getOptionLabelFromRecordUsing(fn (Model $rate) => "{$rate->category->name} {$rate->name} {$rate->amount}€"),

                Textarea::make('note')
                    ->label(__('Comment'))
                    ->autosize(),


                TextInput::make('amount')
                    ->label(__('Price'))
                    ->numeric()
                    ->prefix('€')
                    ->maxValue(42949672.95)
                    ->helperText(__('Leave the field empty to use the default club rate price')),

                DatePicker::make('created_at')
                    ->required()
                    ->label(__('Date'))
                    ->native(false),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {


        return $table
            ->columns([
                TextColumn::make('membership_id')->searchable(false),

                TextColumn::make('clubRate.full_name')->searchable(false),

                TextColumn::make('price')
                    ->label(__('Price'))
                    ->searchable(false),

                TextColumn::make('created_at')
                    ->label(__('Created at'))
                    ->date('d.m.Y')
                    ->searchable(false),

                TextColumn::make('deadline')
                    ->label(__('Deadline'))
                    ->date('d.m.Y')
                    ->searchable(false),

                TextColumn::make('valid_date_until')
                    ->label(__('Valid to'))
                    ->date('d.m.Y')
                    ->searchable(false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->createAnother(false)
                    ->visible(!isset($this->getOwnerRecord()->clubMember)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
