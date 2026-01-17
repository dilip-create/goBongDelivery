<?php

namespace App\Filament\Resources\StorOrderResource\Pages;

use App\Filament\Resources\StorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStorOrder extends EditRecord
{
    protected static string $resource = StorOrderResource::class;

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
