<?php

namespace App\Filament\Resources\StorResource\Pages;

use App\Filament\Resources\StorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStor extends EditRecord
{
    protected static string $resource = StorResource::class;

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
