<?php

namespace App\Filament\Resources\RateCategoryResource\Pages;

use App\Filament\Resources\RateCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRateCategory extends EditRecord
{
    protected static string $resource = RateCategoryResource::class;

    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }
 
    
    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
