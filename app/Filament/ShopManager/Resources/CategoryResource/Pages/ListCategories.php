<?php

namespace App\Filament\ShopManager\Resources\CategoryResource\Pages;

use App\Filament\ShopManager\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
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

    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('message.All')),
            'Show trending or popular' => Tab::make(__('message.Show trending or popular'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('trending_status', 1)),
            'Show' => Tab::make(__('message.Show'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('cat_status', 1)),
           
        ];
    }

    
}
