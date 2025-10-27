<?php

namespace App\Filament\ShopManager\Resources\StorFoodResource\Pages;

use App\Filament\ShopManager\Resources\StorFoodResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStorFood extends ListRecords
{
    protected static string $resource = StorFoodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumb(): string
    {
        return __('message.List');
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('message.All')),
            'Show trending or popular' => Tab::make(__('message.Show trending or popular'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('trending_status', 1)),
            'Open' => Tab::make(__('message.Open'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 1)),
           
        ];
    }
}
