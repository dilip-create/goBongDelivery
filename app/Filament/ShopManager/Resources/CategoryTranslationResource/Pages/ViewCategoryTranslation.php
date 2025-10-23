<?php

namespace App\Filament\ShopManager\Resources\CategoryTranslationResource\Pages;

use App\Filament\ShopManager\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCategoryTranslation extends ViewRecord
{
    protected static string $resource = CategoryTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
