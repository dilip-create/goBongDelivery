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

class StorOrderResource extends Resource
{
    protected static ?string $model = StorOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            ->columns([
                Tables\Columns\TextColumn::make('stor_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('storLoginId')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cust_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_key')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stor_food_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cart_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_cost_price')
                    ->searchable(),
                Tables\Columns\TextColumn::make('subTotal')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distance_between_shop_customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('minimum_order_diffrence')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shipping_charge')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rider_charge')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owncharge_form_riderside')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owncharge_form_storside')
                    ->searchable(),
                Tables\Columns\TextColumn::make('new_customer_discount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('discount_offer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('totalPayAmount')
                    ->searchable(),
                Tables\Columns\TextColumn::make('currency_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('TransactionId')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_time')
                    ->searchable(),
                Tables\Columns\TextColumn::make('gateway_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rider_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('assign_status'),
                Tables\Columns\TextColumn::make('latitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('longitude')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'create' => Pages\CreateStorOrder::route('/create'),
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
