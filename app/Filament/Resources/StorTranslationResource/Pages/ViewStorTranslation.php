<?php

namespace App\Filament\Resources\StorTranslationResource\Pages;

use App\Filament\Resources\StorTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStorTranslation extends ViewRecord
{
    protected static string $resource = StorTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
