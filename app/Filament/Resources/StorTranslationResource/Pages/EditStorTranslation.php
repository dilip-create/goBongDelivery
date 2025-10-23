<?php

namespace App\Filament\Resources\StorTranslationResource\Pages;

use App\Filament\Resources\StorTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorTranslation extends EditRecord
{
    protected static string $resource = StorTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
