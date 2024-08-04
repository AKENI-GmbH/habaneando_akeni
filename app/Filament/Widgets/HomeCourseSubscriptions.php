<?php

namespace App\Filament\Widgets;

use App\Models\CourseSubscription;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class HomeCourseSubscriptions extends BaseWidget
{

    protected static ?string $heading = 'Course Subscriptions';

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getQuery())
            ->columns([
                TextColumn::make('course.name')
                    ->label('Course')
                    ->url(fn (CourseSubscription $record) => route('filament.admin.resources.courses.show', $record->course->slug)),
                TextColumn::make('customer.first_name')
                    ->label('Name')
                    ->url(fn (CourseSubscription $record) => route('filament.admin.resources.customers.edit', $record->customer_id)),
                TextColumn::make('customer.last_name')
                    ->label('Last name')
                    ->url(fn (CourseSubscription $record) => route('filament.admin.resources.customers.edit', $record->customer_id)),
                TextColumn::make('amount')
                    ->label('Amount'),
                TextColumn::make('created_at')->date('d-m-y'),
                TextColumn::make('valid_to')
                    ->label('Valid To'),
            ])->defaultSort('created_at', 'desc');
    }

    protected function getQuery(): Builder
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return CourseSubscription::query()->orderBy('created_at', 'desc')->take(20);
    }
}
