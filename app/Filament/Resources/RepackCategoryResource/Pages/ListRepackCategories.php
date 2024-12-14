<?php

namespace App\Filament\Resources\RepackCategoryResource\Pages;

use App\Filament\Resources\RepackCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRepackCategories extends ListRecords
{
    protected static string $resource = RepackCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
