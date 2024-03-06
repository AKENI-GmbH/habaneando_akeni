<?php

namespace App\Filament\Resources\CourseSubcategoryResource\Pages;

use App\Filament\Resources\CourseSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCourseSubcategories extends ListRecords
{
    protected static string $resource = CourseSubcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
