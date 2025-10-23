<?php

namespace App\Filament\ShopManager\Resources\CategoryTranslationResource\Pages;

use App\Filament\ShopManager\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryTranslation extends EditRecord
{
    protected static string $resource = CategoryTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
