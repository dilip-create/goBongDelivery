<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Models\StorOrder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class AdminDashboard extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $pollingInterval = '5s';
    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -1;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.admin-dashboard';

    /* ================= HEADER WIDGETS ================= */
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsAdminOverview::class,
        ];
    }
     /* 🔁 GLOBAL POLLING */
    protected function getPollingInterval(): ?string
    {
        return '5s';
    }

    /* 🔁 FORCE FULL REFRESH */
    protected $listeners = [
        'refreshDashboard' => '$refresh',
    ];

    // protected function getPollingInterval(): ?string
    // {
    //     return '5s';
    // }

    /* ================= TABLE ================= */
    public function table(Table $table): Table
    {
        return $table
            /* 🔄 AUTO REFRESH EVERY 10 SECONDS */
            // ->pollingInterval('10s')

            /* ================= BASE QUERY (TODAY + LATEST STATUS) ================= */
            ->query(
                StorOrder::query()
                    ->joinSub(
                        StorOrder::selectRaw('MAX(id) as id')
                            ->whereDate('created_at', Carbon::today())
                            ->groupBy('order_key'),
                        'latest_orders',
                        'stor_orders.id',
                        '=',
                        'latest_orders.id'
                    )
                    ->select('stor_orders.*')
                    ->orderByDesc('stor_orders.id')
            )

            /* ================= COLUMNS ================= */
            ->columns([
                Tables\Columns\TextColumn::make('order_key')
                    ->label('Order')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-eye')
                    ->url(fn ($record) =>
                        url('/myOrder/orderDetails/' . base64_encode((string) $record->order_key))
                    )
                    ->openUrlInNewTab()
                    ->searchable(),

                Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'danger',
                        'awaiting verification' => 'warning',
                        'success' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('amount_distance')
                    ->label('Amount / Distance')
                    ->getStateUsing(fn ($record) =>
                        $record->totalPayAmount . ' ' .
                        $record->getCurrencydata->currency_symbol .
                        ' / ' . $record->distance_between_shop_customer . ' km'
                    ),

                Tables\Columns\TextColumn::make('getShopName.name')
                    ->label('Store Name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer')
                    ->label('Customer')
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        '<strong>' . Str::ucfirst($record->getCustomerdata->name) . '</strong><br>' .
                        $record->getCustomerdata->phoneNumber
                    ),

                Tables\Columns\TextColumn::make('rider')
                    ->label('Rider')
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        '<strong>' . e(optional($record->getRiderdata)->name ?? '—') . '</strong><br>' .
                        e(optional($record->getRiderdata)->mobile ?? '—')
                    ),

                Tables\Columns\TextColumn::make('assign_status')
                    ->label('Assign Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => ucfirst($state))
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'danger',
                        'assigntoRider',
                        'acceptedbyRider',
                        'riderGoingToStor',
                        'arrivedatstor',
                        'onthewayToDeliver',
                        'arrivedatLocation' => 'primary',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Order Date')
                    ->dateTime('d-M-Y h:i:s'),
            ])

            /* ================= STATUS "TABS" (SELECT FILTER) ================= */
            ->filtersLayout(FiltersLayout::Hidden)
            ->filtersFormColumns(1)

            ->filters([
                SelectFilter::make('assign_status')
                    ->label('Order Status')
                    ->searchable()
                    // ->default('pending') // ⭐ DEFAULT TAB
                    ->options(fn () => $this->getStatusOptionsWithCounts())
                    ->query(function (Builder $query, array $data) {
                        if (!empty($data['value'])) {
                            $query->where('assign_status', $data['value']);
                        }
                    }),
            ])

            /* ================= ACTIONS ================= */
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    /* ================= STATUS COUNTS ================= */
    protected function getStatusOptionsWithCounts(): array
    {
        $counts = StorOrder::query()
            ->joinSub(
                StorOrder::selectRaw('MAX(id) as id')
                    ->whereDate('created_at', Carbon::today())
                    ->groupBy('order_key'),
                'latest',
                'stor_orders.id',
                '=',
                'latest.id'
            )
            ->selectRaw('assign_status, COUNT(*) as total')
            ->groupBy('assign_status')
            ->pluck('total', 'assign_status')
            ->toArray();

        return [
            'pending'            => '⏳ Pending (' . ($counts['pending'] ?? 0) . ')',
            'assigntoRider'      => '🚚 Assign To Rider (' . ($counts['assigntoRider'] ?? 0) . ')',
            'acceptedbyRider'    => '✅ Accepted (' . ($counts['acceptedbyRider'] ?? 0) . ')',
            'riderGoingToStor'   => '🏪 Going To Store (' . ($counts['riderGoingToStor'] ?? 0) . ')',
            'arrivedatstor'      => '📦 Arrived At Store (' . ($counts['arrivedatstor'] ?? 0) . ')',
            'onthewayToDeliver'  => '🛵 On The Way (' . ($counts['onthewayToDeliver'] ?? 0) . ')',
            'arrivedatLocation'  => '📍 Arrived (' . ($counts['arrivedatLocation'] ?? 0) . ')',
            'delivered'          => '🎉 Delivered (' . ($counts['delivered'] ?? 0) . ')',
            'cancelled'          => '❌ Cancelled (' . ($counts['cancelled'] ?? 0) . ')',
        ];
    }
}