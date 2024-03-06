<?php

namespace App\Filament\Resources\CourseSubcategoryResource\Pages;

use App\Filament\Resources\CourseSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseSubcategory extends EditRecord
{
    protected static string $resource = CourseSubcategoryResource::class;

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
