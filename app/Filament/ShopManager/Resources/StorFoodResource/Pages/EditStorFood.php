<?php

namespace App\Filament\ShopManager\Resources\StorFoodResource\Pages;

use App\Filament\ShopManager\Resources\StorFoodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorFood extends EditRecord
{
    protected static string $resource = StorFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
