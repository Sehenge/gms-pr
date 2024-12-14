<?php

namespace App\Filament\Resources\RepackCategoryResource\Pages;

use App\Filament\Resources\RepackCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRepackCategory extends EditRecord
{
    protected static string $resource = RepackCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
