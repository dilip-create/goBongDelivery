<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TipResource\Pages;
use App\Filament\Resources\TipResource\RelationManagers;
use App\Models\Tip;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Rider;
use App\Models\Customer;
use Illuminate\Support\Str;
use Filament\Tables\Columns\ImageColumn;

class TipResource extends Resource
{
    protected static ?string $model = Tip::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    public static function getNavigationGroup(): ?string{
        return __('message.Order Management');
    }
    public static function getModelLabel(): string{
        return __('message.Rider tips');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_key')
                    ->maxLength(255)
                    ->label(__('message.Order'))
                    ->disabled()
                    ->prefixIcon('heroicon-o-tag'),
                Forms\Components\Select::make('cust_id')
                    ->label(__('message.Customer name'))
                    ->options(
                        Customer::orderByDesc('id')
                            ->get()
                            ->mapWithKeys(function ($customer) {
                                return [$customer->id => ucfirst($customer->name) . ' => ' . $customer->phoneNumber];
                            })
                            ->toArray()
                    )
                    ->prefixIcon('heroicon-m-user')
                    ->required()
                    ->disabledOn('edit'),
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
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('amount')
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->readonly()
                    ->label(__('message.Amount'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('desc')
                    ->label(__('message.Description'))
                    ->disabled()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('TransactionId')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('payment_type')
                    ->label(__('message.Payment type'))
                    ->maxLength(255)
                    ->disabled()
                    ->default(null),
                Forms\Components\TextInput::make('payment_time')
                    ->label(__('message.Payment time'))
                    ->maxLength(255)
                    ->readonly()
                    ->default(null),
                Forms\Components\FileUpload::make('attach_slip')
                                    ->label(__('message.Payment slip'))
                                    ->directory('tipsPaySlip')
                                    ->disabled()
                                    ->image(),
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
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('Serial_number')
                    ->label(__('message.Serial number'))
                    ->badge()
                    ->state(fn($column) => $column->getRowLoop()->iteration),
                Tables\Columns\TextColumn::make('order_key')
                    ->label(__('message.Order'))
                    ->badge()
                    ->color('warning')
                    ->searchable(),
               Tables\Columns\TextColumn::make('getstorTranslation.stor_name')
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
                Tables\Columns\TextColumn::make('combineded')
                    ->label(__('message.Amount'))
                    ->getStateUsing(fn ($record) =>
                        $record->amount . ' ' .
                        $record->getCurrencydata->currency_symbol  ,
                    ),
                Tables\Columns\TextColumn::make('desc')
                    ->label(__('message.Description'))
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
                Tables\Columns\TextColumn::make('payment_time')
                    ->label(__('message.Payment time'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('message.Created at'))
                    ->dateTime('d-M-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('message.Updated at'))
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
               Tables\Actions\EditAction::make()->label(__('message.Update'))->modalHeading(__('message.Update'))->modalButton(__('message.Save changes')),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTips::route('/'),
            // 'create' => Pages\CreateTip::route('/create'),
            // 'view' => Pages\ViewTip::route('/{record}'),
            // 'edit' => Pages\EditTip::route('/{record}/edit'),
        ];
    }
}
