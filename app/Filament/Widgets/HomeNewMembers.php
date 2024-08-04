<?php

namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ClubMember;
use Filament\Tables\Table;
use Carbon\Carbon;

class HomeNewMembers extends BaseWidget
{
    protected static ?string $heading = 'New Members';


    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([
                TextColumn::make('customer.first_name')
                    ->label('name')
                    ->url(fn (ClubMember $record) => route('filament.admin.resources.customers.edit', $record->customer->id)),

                TextColumn::make('customer.last_name')
                    ->label('last name')
                    ->url(fn (ClubMember $record) => route('filament.admin.resources.customers.edit', $record->customer->id)),

                TextColumn::make('clubRate.name'),
                TextColumn::make('clubRate.category.name'),
                TextColumn::make('clubRate.amount')
            ])->defaultSort('created_at', 'desc');
    }

    protected function getQuery(): Builder
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return ClubMember::query()->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
    }
}
