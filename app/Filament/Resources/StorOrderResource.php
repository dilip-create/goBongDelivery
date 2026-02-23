<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorOrderResource\Pages;
use App\Filament\Resources\StorOrderResource\RelationManagers;
use App\Models\StorOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Illuminate\Support\Str;
use Filament\Forms\Components\Select;
use Filament\Resources\Tables\Actions\Action;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;


use Filament\Tables\Columns\ImageColumn;
use App\Models\Rider;
use App\Models\Stor;
use App\Models\User;

class StorOrderResource extends Resource
{
    protected static ?string $model = StorOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    public static function getNavigationGroup(): ?string{
        return __('message.Order Management');
    }
    public static function getModelLabel(): string{
        return __('message.Order History');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('storLoginId')
                    ->label(__('message.Store name'))
                    
                            ->options(
                                User::where('role', 'Shop Manager')->orderByDesc('id')
                                    ->get()
                                    ->mapWithKeys(function ($seller) {
                                        return [$seller->id => ucfirst($seller->name) . ' => ' . $seller->phoneNumber];
                                    })
                                    ->toArray()
                            )
                            ->prefixIcon('heroicon-o-building-office')
                            ->required()
                            ->disabled()
                            ->reactive(),
                Forms\Components\TextInput::make('order_key')
                    ->label(__('message.Order'))
                    ->disabled()
                    ->prefixIcon('heroicon-o-tag'),
                Forms\Components\Select::make('payment_status')
                    ->label(__('message.Payment Status'))
                    ->options([
                                'pending' => 'pending',
                                'awaiting verification' => 'awaiting verification',
                                'success' => 'success',
                            ])
                            ->prefixIcon('heroicon-m-document-currency-dollar')
                    ->required()
                    ->default('pending'),
                Forms\Components\Select::make('order_status')
                            ->label(__('message.Order Status'))
                            ->options([
                                'pending' => 'pending',
                                'ordered' => 'ordered',
                                'cancelled' => 'cancelled',
                                'delivered' => 'delivered',
                            ])
                            ->prefixIcon('heroicon-m-bookmark-square')
                            ->required()
                            ->default('pending'),
                Forms\Components\Select::make('rider_id')
                            ->label(__('message.Riders'))
                            ->options(
                                Rider::orderByDesc('id')
                                    ->get()
                                    ->mapWithKeys(function ($rider) {
                                        return [$rider->id => ucfirst($rider->name) . ' => ' . $rider->mobile];
                                    })
                                    ->toArray()
                            )
                            ->prefixIcon('heroicon-o-rocket-launch')
                            ->searchable()
                            ->required(),
                Forms\Components\Select::make('assign_status')
                    ->label(__('message.Delivery status'))
                    ->options([
                                'pending' => 'pending',
                                'assigntoRider' => 'assigntoRider',
                                'acceptedbyRider' => 'acceptedbyRider',
                                'riderGoingToStor' => 'riderGoingToStor',
                                'arrivedatstor' => 'arrivedatstor',
                                'onthewayToDeliver' => 'onthewayToDeliver',
                                'arrivedatLocation' => 'arrivedatLocation',
                                'delivered' => 'delivered',
                                'cancelled' => 'cancelled',
                            ])
                    ->prefixIcon('heroicon-m-ticket')
                    ->required()
                    ->default('pending'),
                Forms\Components\Textarea::make('special_instructions')
                    ->label(__('message.Special Instructions'))
                    ->disabled(),
                Forms\Components\Textarea::make('cancel_reason')
                    ->label(__('message.Cancellation reason'))
                    ->maxLength(255),
                Forms\Components\FileUpload::make('attach_slip')
                                    ->label(__('message.Payment slip'))
                                    ->directory('paymentSlip')
                                    ->disabled()
                                    ->image(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) =>
                $query->whereIn('id', function ($sub) {
                    $sub->selectRaw('MAX(id)')
                        ->from('stor_orders')
                        ->groupBy('order_key');
                })
            )
            ->headerActions([
                // ExportAction::make()
                ExportAction::make()->label(__('message.Export'))->exports([
                    ExcelExport::make()->fromTable()->except([
                        'Serial_number', 'updated_at',
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                        ->label(__('message.Modify order'))
                        ->modalHeading(__('message.Modify order'))
                        ->modalButton(__('message.Save changes'))
                        ->using(function (\App\Models\StorOrder $record, array $data) {

                            \App\Models\StorOrder::withoutGlobalScopes()
                                ->where('order_key', $record->order_key)
                                ->update([
                                    'payment_status' => $data['payment_status'],
                                    'order_status'   => $data['order_status'],
                                    'rider_id'       => $data['rider_id'],
                                    'assign_status'  => $data['assign_status'],
                                    'cancel_reason'  => $data['cancel_reason'] ?? null,
                                ]);

                            return $record->refresh();
                        }),
                Tables\Actions\ViewAction::make()->label(__('message.Look at the bill'))->modalHeading(__('message.View')),
                // Tables\Actions\Action::make('Custom Action')->label(__('message.Link'))->url('https://heroicons.com/outline')->icon('heroicon-m-link')->color('success')->openUrlInNewTab(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()->label(__('message.Export'))->exports([
                        ExcelExport::make()->fromTable()->except([
                            'Serial_number', 'updated_at',
                        ]),
                        // ExcelExport::make()->fromTable()->only([
                        //     'email', 'phone',
                        // ]),
                    ])
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStorOrders::route('/'),
            // 'create' => Pages\CreateStorOrder::route('/create'),
            // 'view' => Pages\ViewStorOrder::route('/{record}'),
            // 'edit' => Pages\EditStorOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
