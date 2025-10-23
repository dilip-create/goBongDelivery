<?php

namespace App\Filament\Resources\StorResource\Pages;

use App\Filament\Resources\StorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStor extends ViewRecord
{
    protected static string $resource = StorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
