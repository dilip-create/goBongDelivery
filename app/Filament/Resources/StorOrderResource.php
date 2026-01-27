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
                Forms\Components\TextInput::make('stor_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('storLoginId')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('cust_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('order_key')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('stor_food_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('cart_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('total_cost_price')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('subTotal')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('distance_between_shop_customer')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('minimum_order_diffrence')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('shipping_charge')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('rider_charge')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('owncharge_form_riderside')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('owncharge_form_storside')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('new_customer_discount')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('discount_offer')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('totalPayAmount')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('currency_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('TransactionId')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('payment_type')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('payment_status')
                    ->required()
                    ->maxLength(255)
                    ->default('pending'),
                Forms\Components\Textarea::make('response_all')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('attach_slip')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('payment_time')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('gateway_name')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('order_status')
                    ->required()
                    ->maxLength(255)
                    ->default('pending'),
                Forms\Components\TextInput::make('order_date')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('rider_id')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('special_instructions')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('assign_status')
                    ->required(),
                Forms\Components\Textarea::make('cancel_reason')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('latitude')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('longitude')
                    ->maxLength(255)
                    ->default(null),
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
                    ->getStateUsing(fn ($record) =>
                        $record->totalPayAmount . ' ' .
                        $record->getCurrencydata->currency_symbol . ' / ' .
                        $record->distance_between_shop_customer . ' km' ,
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('getShopName.name')
                    ->label(__('message.Store name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('combinessd')
                    ->label(__('message.Customer name'))
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        '<strong>' . Str::ucfirst($record->getCustomerdata->name) . '</strong><br>' .
                        Str::ucfirst($record->getCustomerdata->phoneNumber)
                    )
                    ->searchable(),
                Tables\Columns\TextColumn::make('deliveryBoydata.name')
                    ->label(__('message.Rider name'))
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('order_status')
                    ->label(__('message.Order Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'warning',
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
                        'assigned' => 'primary',
                        'accepted' => 'success',
                        'shipped' => 'warning',
                        'rejected' => 'danger',
                        'delivered' => 'success',
                        'cancelled' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('order_date')
                    ->label(__('message.Order Date'))
                    ->dateTime('d-M-Y')
                    ->searchable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(__('message.View'))->modalHeading(__('message.View')),
                Tables\Actions\EditAction::make()->label(__('message.Edit'))->modalHeading(__('message.Edit'))->modalButton(__('message.Save changes')),
                Tables\Actions\Action::make('Custom Action')->label(__('message.Link'))->url('https://heroicons.com/outline')->icon('heroicon-m-link')->color('success')->openUrlInNewTab(),
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
            'view' => Pages\ViewStorOrder::route('/{record}'),
            'edit' => Pages\EditStorOrder::route('/{record}/edit'),
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
