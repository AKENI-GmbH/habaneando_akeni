<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use Carbon\Carbon;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class HomeNewCustomers extends BaseWidget
{
    protected static ?string $heading = 'New Customers';


    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([
                TextColumn::make('first_name')
                    ->url(fn (Customer $record) => route('filament.admin.resources.customers.edit', $record->id)),
                TextColumn::make('last_name')
                    ->url(fn (Customer $record) => route('filament.admin.resources.customers.edit', $record->id)),
                TextColumn::make('email'),
                TextColumn::make('created_at')->date('d-m-Y'),

            ]);
    }

    protected function getQuery(): Builder
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return Customer::query()
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
    }
}
