<?php

namespace App\Filament\Resources\StorOrderResource\Pages;

use App\Filament\Resources\StorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStorOrders extends ListRecords
{
    protected static string $resource = StorOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
