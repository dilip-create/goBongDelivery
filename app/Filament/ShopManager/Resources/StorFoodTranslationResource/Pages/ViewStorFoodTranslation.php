<?php

namespace App\Filament\ShopManager\Resources\StorFoodTranslationResource\Pages;

use App\Filament\ShopManager\Resources\StorFoodTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStorFoodTranslation extends ViewRecord
{
    protected static string $resource = StorFoodTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
