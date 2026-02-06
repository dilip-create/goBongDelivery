<?php

namespace App\Filament\Resources\RiderResource\Pages;

use App\Filament\Resources\RiderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListRiders extends ListRecords
{
    protected static string $resource = RiderResource::class;

    public function getBreadcrumb(): string
    {
        return __('message.List');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label(__('message.New Rider'))->modalButton(__('message.Save')),
             
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('message.All')),
            'Available for delivery' => Tab::make(__('message.Available for delivery'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('available_for_delivery', 1)),
            'Status' => Tab::make(__('message.Status'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)),
           
        ];
    }
}
