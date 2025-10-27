<?php

namespace App\Filament\ShopManager\Resources\CategoryTranslationResource\Pages;

use App\Filament\ShopManager\Resources\CategoryTranslationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListCategoryTranslations extends ListRecords
{
    protected static string $resource = CategoryTranslationResource::class;

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
            'all' => Tab::make(__('message.All language')),
            'English' => Tab::make(__('message.English'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('language_id', 1)),
            'Thai' => Tab::make(__('message.Thai'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('language_id', 2)),
            'Khmer' => Tab::make(__('message.Khmer'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('language_id', 3)),
        ];
    }
}
