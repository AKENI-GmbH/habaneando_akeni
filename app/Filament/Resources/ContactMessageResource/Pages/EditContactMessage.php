<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('reply')
                ->label('Reply')
                ->color('primary')
                ->url(function () {
                    return 'mailto:' . $this->record->email;
                })
                ->openUrlInNewTab(),
        ];
    }
}
