<?php
namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;
use App\Models\Stor;
use App\Models\StorOrder;
// use App\Models\Restaurant;
// use App\Models\Seller;
// use App\Models\DeliveryBoy;
// use App\Models\RestaurantCategory;
// use App\Models\RestaurantFood;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StatsAdminOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '5s';
    protected function getStats(): array
    {
        return [
            Stat::make(__('message.Active Customers'), Customer::query()->where('status', 1)->count())
                ->description(__('message.Active Customers'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.Disable Customers'), Customer::query()->where('status', 0)->count())
                ->description(__('message.Disable Customers'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
             // form STORES Infomation code START
            Stat::make(__('message.All Stores'), Stor::query()->count())
                ->description(__('message.All Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.Open Stores'), Stor::query()->where('openStatus', 1)->count())
                ->description(__('message.Open Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make(__('message.Closed Stores'), Stor::query()->whereDate('created_at', Carbon::today())->where('openStatus', 0)->count())
                ->description(__('message.Closed Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),

            Stat::make(__('message.Today Orders'), StorOrder::query()->whereDate('created_at', Carbon::today())->count())
                ->description(__('message.Today Orders'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make(__('message.Foods'), Customer::query()->count())
                ->description(__('message.All foods'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.Delivery Boy'), Customer::query()->count())
                ->description(__('message.All DeliveryBoy'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }

    

   
}
