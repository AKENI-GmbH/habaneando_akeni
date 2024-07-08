<?php

namespace App\Filament\Resources\EventSubscriptionResource\Pages;

use App\Filament\Resources\EventSubscriptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEventSubscription extends EditRecord
{
    protected static string $resource = EventSubscriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
