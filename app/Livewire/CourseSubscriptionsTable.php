<?php

namespace App\Livewire;

use App\Models\CourseSubscription;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Livewire\Component;

class CourseSubscriptionsTable extends Component implements HasTable
{
    use InteractsWithTable;

    public bool $isCachingForms = false;

    protected function getTableQuery()
    {
        return CourseSubscription::query();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('name'),
            TextColumn::make('email'),
        ];
    }

    public function hasCachedForm(): bool
    {
        return false;
    }

    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function makeForm(): ?TranslatableContentDriver
    {
        return null;
    }

    public function render()
    {
        return view('livewire.course-subscriptions-table');
    }
}
