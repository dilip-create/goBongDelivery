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

class StoreRevenueReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.store-revenue-report';

    // /* Sidebar group */
    // public static function getNavigationGroup(): ?string
    // {
    //     return __('message.Manage Report');
    // }
    // /* Sidebar item label */
    // public static function getNavigationLabel(): string
    // {
    //     return __('message.Store Revenue Report');
    // }
    // /* Page title */
    // public function getTitle(): string
    // {
    //     return __('message.Store Revenue Report');
    // }
   

    public function table(Table $table): Table
    {
        return $table
            ->query(
                StorOrder::query()
                    ->select([
                        'order_key',
                        'stor_id',
                        DB::raw('SUM(total_cost_price) as store_revenue'),
                        DB::raw('MAX(order_date) as order_date'),
                        DB::raw("CONCAT(order_key, '-', stor_id) as table_key"), // unique key for Filament
                    ])
                    ->where('order_status', 'delivered')
                    ->whereIn('id', function ($subquery) {
                        $subquery->selectRaw('MAX(id)')
                            ->from('stor_orders')
                            ->groupBy('order_key', 'stor_id');
                    })
                    ->groupBy('order_key', 'stor_id')
                     ->orderBy('order_date', 'DESC') 
            )
            ->headerActions([
                ExportAction::make()
                    ->label(__('message.Export'))
                    ->exports([
                        ExcelExport::make()
                            ->fromTable()
                             ->withFilename(
                                    __('message.Store Revenue Report') . '_' . now()->format('dMY') . '.xlsx'
                                )
                            ->except([
                                'Serial_number',
                                'Total Store Revenue',
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
                Tables\Columns\TextColumn::make('getstorTranslation.stor_name')
                    ->label(__('message.Store name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('message.Order Date'))
                    ->dateTime('d-M-Y h:i:s')
                    ->searchable(),
                Tables\Columns\TextColumn::make('store_revenue')
                    ->label(__('message.Store Revenue'))
                    ->summarize(Sum::make()->label(__('message.Total Store Revenue')))
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

