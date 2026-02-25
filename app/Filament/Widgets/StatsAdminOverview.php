<?php
namespace App\Filament\Widgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Customer;
use App\Models\Stor;
use App\Models\StorOrder;
use App\Models\Rider;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class StatsAdminOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '5s';
    protected function getStats(): array
    {
        return [
             Stat::make(__('message.Today Orders'), StorOrder::query()->whereDate('created_at', Carbon::today())->count())
                ->description(__('message.Today Orders'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make(__('message.Yesterday Orders'), StorOrder::query()->whereDate('created_at', Carbon::yesterday())->count())
                ->description(__('message.Yesterday Orders'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.Total Customers'), Customer::query()->count())
                ->description(__('message.Total Customers'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
            
             // form STORES Infomation code START
            Stat::make(__('message.All Stores'), Stor::query()->count())
                ->description(__('message.All Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make(__('message.Open Stores'), Stor::query()->where('openStatus', 1)->count())
                ->description(__('message.Open Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.Closed Stores'), Stor::query()->whereDate('created_at', Carbon::today())->where('openStatus', 0)->count())
                ->description(__('message.Closed Stores'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
             // order section 
            Stat::make(__('message.Total Riders'), Rider::query()->count())
                ->description(__('message.Total Riders'))
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make(__('message.Available Riders'), Rider::query()->where('status', 1)->count())
                ->description(__('message.Available Riders'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
            Stat::make(__('message.DayOff Riders'), Rider::query()->where('status', 0)->count())
                ->description(__('message.DayOff Riders'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('danger'),
        ];
    }

    

   
}
