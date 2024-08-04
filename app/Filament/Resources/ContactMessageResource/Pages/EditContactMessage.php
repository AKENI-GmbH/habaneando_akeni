<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContactMessage extends EditRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('markAsRead')
                ->label('Mark as Read')
                ->color('success')
                ->action(function () {
                    $this->record->update(['read' => true]);
                    $this->notify('success', 'Message marked as read successfully!');
                    $this->redirect($this->getResource()::getUrl('index'));
                }),
        ];
    }
}
