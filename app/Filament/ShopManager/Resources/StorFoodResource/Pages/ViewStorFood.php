<?php

namespace App\Filament\ShopManager\Resources\StorFoodResource\Pages;

use App\Filament\ShopManager\Resources\StorFoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStorFood extends ViewRecord
{
    protected static string $resource = StorFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
