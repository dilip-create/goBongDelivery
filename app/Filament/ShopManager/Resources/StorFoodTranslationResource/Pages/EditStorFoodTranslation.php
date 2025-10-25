<?php

namespace App\Filament\ShopManager\Resources\StorFoodTranslationResource\Pages;

use App\Filament\ShopManager\Resources\StorFoodTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorFoodTranslation extends EditRecord
{
    protected static string $resource = StorFoodTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
