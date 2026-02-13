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



class RiderRevenueReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.rider-revenue-report';
    protected static ?string $navigationGroup = 'Manage Report';
    protected static ?string $title = 'Rider Revenue Report';

    // Table query
    public function table(Table $table): Table
    {
        return $table
            ->query(
                StorOrder::query()
                    ->select([
                        'order_key',
                        'rider_id',
                        DB::raw('SUM(owncharge_form_riderside) as rider_revenue'),
                        DB::raw('MAX(order_date) as order_date'),
                        DB::raw("CONCAT(order_key, '-', rider_id) as table_key"), // unique key for Filament
                    ])
                    ->where('order_status', 'delivered')
                    ->whereIn('id', function ($subquery) {
                        $subquery->selectRaw('MAX(id)')
                            ->from('stor_orders')
                            ->groupBy('order_key', 'rider_id');
                    })
                    ->groupBy('order_key', 'rider_id')
            )
            ->headerActions([
                ExportAction::make()->label(__('message.Export'))->exports([
                    ExcelExport::make()->fromTable()->except([
                        'Serial_number', 'Total Rider Revenue',
                    ]),
                    // ExcelExport::make()->fromTable()->only([
                    //     'email', 'phone',
                    // ]),
                ])

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
                Tables\Columns\TextColumn::make('rider_id')
                    ->label(__('message.Rider name'))
                    ->getStateUsing(fn($record) => optional($record->getRiderdata)->name . ' - ' . optional($record->getRiderdata)->mobile)
                    ->searchable(
                        query: function (Builder $query, string $search) {
                            $query->orWhereHas('getRiderdata', function ($q) use ($search) {
                                $q->where('name', 'like', "%{$search}%")
                                ->orWhere('mobile', 'like', "%{$search}%");
                            });
                        }
                    )
                    ->html(),

                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('message.Order Date'))
                    ->dateTime('d-M-Y')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rider_revenue')
                    ->label(__('message.Rider Revenue'))
                    ->summarize(Sum::make()->label(__('message.Total Rider Revenue')))
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
