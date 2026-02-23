<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Builder;
use App\Models\StorOrder;
use Carbon\Carbon;

use Illuminate\Support\Str;


class AdminDashboard extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationLabel = 'Dashboard';
    protected static ?string $title = 'Dashboard';
    protected static ?int $navigationSort = -1;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.admin-dashboard';

    /* =============== TOP WIDGETS======================= */
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsAdminOverview::class,
        ];
    }

    /* =========================TABLE========================= */
    public function table(Table $table): Table
    {
        return $table
            /* ✅ QUERY (MANDATORY IN v3) */
            ->query(
                StorOrder::query()
                    ->whereDate('created_at', Carbon::today())
                    ->whereIn('id', function ($sub) {
                        $sub->selectRaw('MAX(id)')
                            ->from('stor_orders')
                            ->groupBy('order_key');
                    })
                    ->orderByDesc('id')
            )

            ->columns([
                Tables\Columns\TextColumn::make('order_key')
                    ->label(__('message.Order'))
                    // ->formatStateUsing(fn ($state) => 'View Order')
                    ->badge()
                    ->color('success')
                    ->icon('heroicon-m-eye')
                    ->tooltip(__('message.Click to view order details'))
                    ->url(fn ($record) => url('/myOrder/orderDetails/' . base64_encode((string) $record->order_key)))
                    ->openUrlInNewTab()
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->label(__('message.Payment Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',
                        'awaiting verification' => 'warning',
                        'success' => 'success',
                    }),
                Tables\Columns\TextColumn::make('combineded')
                    ->label(__('message.Amount/Distance'))
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        $record->totalPayAmount . ' ' .
                        $record->getCurrencydata->currency_symbol . ' / ' .
                        $record->distance_between_shop_customer . ' km' ,
                    ),
                Tables\Columns\TextColumn::make('getShopName.name')
                    ->label(__('message.Store name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('combinessd')
                    ->label(__('message.Customer name'))
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        '<strong>' . Str::ucfirst($record->getCustomerdata->name) . '</strong><br>' .
                        Str::ucfirst($record->getCustomerdata->phoneNumber)
                    ),
                Tables\Columns\TextColumn::make('combinedfff')
                    ->label(__('message.Rider name'))
                    ->html()
                    ->getStateUsing(function ($record) {
                        $riderName = optional($record->getRiderdata)->name ?? '—';
                        $phone     = optional($record->getRiderdata)->mobile ?? '—';

                        return '<strong>' . e(Str::ucfirst($riderName)) . '</strong><br>' .
                            e($phone);
                    }),
                Tables\Columns\TextColumn::make('order_status')
                    ->label(__('message.Order Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'ordered' => 'warning',
                        'cancelled' => 'danger',
                        'delivered' => 'success',
                    }),
                Tables\Columns\TextColumn::make('assign_status')
                    ->label(__('message.Assign Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'danger',

                        'assigntoRider' => 'primary',
                        'acceptedbyRider' => 'primary',
                        'riderGoingToStor' => 'primary',
                        'arrivedatstor' => 'primary',
                        'onthewayToDeliver' => 'primary',
                        'arrivedatLocation' => 'primary',
                        
                       

                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('message.Order Date'))
                    ->dateTime('d-M-Y h:i:s')
                    ->searchable(),
            ])

            /* =========================LEFT SIDEBAR FILTERS========================= */
            ->filtersLayout(FiltersLayout::Hidden)
            ->filtersFormColumns(1)
            ->filters([
                Tables\Filters\Filter::make('success')
                    ->label(__('message.Success'))
                    ->query(fn (Builder $q) => $q->where('payment_status', 'success')),
                Tables\Filters\Filter::make('pending')
                    ->label(__('message.Pending'))
                    ->query(fn (Builder $q) => $q->where('order_status', 'pending')),

                Tables\Filters\Filter::make('awaiting')
                    ->label(__('message.Awaiting verification'))
                    ->query(fn (Builder $q) => $q->where('payment_status', 'awaiting verification')),

                Tables\Filters\Filter::make('riderGoingToStor')
                    ->label(__('message.RiderGoingToStore'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'riderGoingToStor')),

                Tables\Filters\Filter::make('arrivedatstor')
                    ->label(__('message.ArrivedatStore'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'arrivedatstor')),

                Tables\Filters\Filter::make('ontheway')
                    ->label(__('message.OnthewayToDeliver'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'onthewayToDeliver')),

                Tables\Filters\Filter::make('arrivedatLocation')
                    ->label(__('message.ArrivedatLocation'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'arrivedatLocation')),

                Tables\Filters\Filter::make('delivered')
                    ->label(__('message.Delivered'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'delivered')),

                Tables\Filters\Filter::make('cancelled')
                    ->label(__('message.Cancelled'))
                    ->query(fn (Builder $q) => $q->where('assign_status', 'cancelled')),
            ])

            /* =========================
                ACTIONS
            ========================= */
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}