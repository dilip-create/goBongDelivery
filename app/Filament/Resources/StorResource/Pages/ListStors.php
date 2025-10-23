<?php

namespace App\Filament\Resources\StorResource\Pages;

use App\Filament\Resources\StorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStors extends ListRecords
{
    protected static string $resource = StorResource::class;
    public function getBreadcrumb(): string
    {
        return __('message.List');
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
