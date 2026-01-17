<?php

namespace App\Filament\Resources\StorOrderResource\Pages;

use App\Filament\Resources\StorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStorOrder extends ViewRecord
{
    protected static string $resource = StorOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
