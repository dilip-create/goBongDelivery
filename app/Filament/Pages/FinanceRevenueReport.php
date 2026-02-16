<?php

namespace App\Filament\Pages;

use App\Models\StorOrder;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\Summarizers\Sum;

use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Resources\Tables\Actions\Action;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class FinanceRevenueReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.finance-revenue-report';
    protected static ?string $title = null;

     /* Sidebar group */
    // public static function getNavigationGroup(): ?string
    // {
    //     return __('message.Manage Report');
    // }
    // /* Sidebar item label */
    // public static function getNavigationLabel(): string
    // {
    //     return __('message.GoBong Finance Report');
    // }
    // /* Page title */
    // public function getTitle(): string
    // {
    //     return __('message.GoBong Finance Report');
    // }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StorOrder::query()
                    ->select([
                        'order_key',
                        DB::raw('MAX(totalPayAmount) as totalPayAmount'),
                        DB::raw('MAX(total_cost_price) as total_cost_price'),
                        DB::raw('MAX(rider_charge) as shipping_charge'),
                        DB::raw('SUM(owncharge_form_riderside + owncharge_form_storside) as finance_revenue'),
                        DB::raw('MAX(order_date) as order_date'),
                        DB::raw("CONCAT(order_key, '-', MAX(order_date)) as table_key"), // ✅ FIXED
                    ])
                    ->where('order_status', 'delivered')
                    ->whereIn('id', function ($subquery) {
                        $subquery->selectRaw('MAX(id)')
                            ->from('stor_orders')
                            ->groupBy('order_key', 'stor_id');
                    })
                    ->groupBy('order_key')
                    ->orderBy('order_date', 'DESC') 
            )
            ->headerActions([
                ExportAction::make()
                    ->label(__('message.Export'))
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                             ->withFilename(
                                __('message.GoBong Revenue Report') . '_' . now()->format('dMY') . '.xlsx'
                            )
                            ->except([
                                'Serial_number',
                                'Total Rider Revenue',
                            ]),
                    ]),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('Serial_number')
                    ->label(__('message.Serial number'))
                    ->badge()
                    ->state(fn($column) => $column->getRowLoop()->iteration),
                Tables\Columns\TextColumn::make('order_key')
                    ->label(__('message.Order'))
                    ->badge()
                    ->color('success')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('message.Order Date'))
                    ->dateTime('d-M-Y h:i:s')
                    ->searchable(),
                Tables\Columns\TextColumn::make('totalPayAmount')
                    ->label(__('message.Payment amount'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_cost_price')
                    ->label(__('message.Cost charge'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_charge')
                    ->label(__('message.Shipping charge'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('finance_revenue')
                    ->label(__('message.Revenue'))
                    ->summarize(Sum::make()->label(__('message.Total Revenue')))
                    ->money('THB'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('report_type')
                    ->label(__('message.Report Type'))
                    ->options([
                        'daily' => 'Daily',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (!isset($data['value'])) return;

                        if ($data['value'] === 'daily') {
                            $query->whereDate('order_date', now());
                        }

                        if ($data['value'] === 'monthly') {
                            $query->whereMonth('order_date', now()->month)
                                  ->whereYear('order_date', now()->year);
                        }

                        if ($data['value'] === 'yearly') {
                            $query->whereYear('order_date', now()->year);
                        }
                    }),
            ]);
    }

    // Provide a unique table key for Filament
    public function getTableRecordKey($record): string
    {
        return $record->table_key; // matches the CONCAT in query
    }
    
}
