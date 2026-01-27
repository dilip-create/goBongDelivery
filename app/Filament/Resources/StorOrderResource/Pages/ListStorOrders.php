<?php

namespace App\Filament\Resources\StorOrderResource\Pages;

use App\Filament\Resources\StorOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStorOrders extends ListRecords
{
    protected static string $resource = StorOrderResource::class;
    public function getBreadcrumb(): string
    {
        return __('message.List');
    }

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }

    public function getTabs(): array
    {
        return [
           'all' => Tab::make(__('message.All')),
            'Success' => Tab::make(__('message.Success'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('payment_status', 'success')),
            'Pending' => Tab::make(__('message.Pending'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('payment_status', 'pending')),
            'Awaiting verification' => Tab::make(__('message.Awaiting verification'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('payment_status', 'awaiting verification')),
            'riderGoingToStor' => Tab::make(__('message.RiderGoingToStore'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'riderGoingToStor')),
            'arrivedatstor' => Tab::make(__('message.ArrivedatStore'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'arrivedatstor')),
            'onthewayToDeliver' => Tab::make(__('message.OnthewayToDeliver'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'onthewayToDeliver')),
            'arrivedatLocation' => Tab::make(__('message.ArrivedatLocation'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'arrivedatLocation')),
            'delivered' => Tab::make(__('message.Delivered'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'delivered')),
            'cancelled' => Tab::make(__('message.Cancelled'))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('assign_status', 'cancelled')),
         
            
        ];
    }

}
