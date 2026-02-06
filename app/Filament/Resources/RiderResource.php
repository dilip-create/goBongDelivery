<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RiderResource\Pages;
use App\Filament\Resources\RiderResource\RelationManagers;
use App\Models\Rider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\User;
use Filament\Tables\Columns\TextColumn;

class RiderResource extends Resource
{
    protected static ?string $model = Rider::class;

    protected static ?string $navigationIcon = 'heroicon-o-rocket-launch'; 
    public static function getNavigationGroup(): ?string{
        return __('message.Manage Riders');
    }
    public static function getModelLabel(): string{
        return __('message.Riders');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('riderLoginId')
                            ->label(__('message.Riders'))
                            ->options(
                                User::where('role', 'Rider')->orderByDesc('id')
                                    ->get()
                                    ->mapWithKeys(function ($riderauth) {
                                        return [$riderauth->id => ucfirst($riderauth->name) . ' => ' . $riderauth->phoneNumber];
                                    })
                                    ->toArray()
                            )
                            ->prefixIcon('heroicon-o-tag')
                            ->searchable()
                            ->required(),
                Forms\Components\TextInput::make('riderBoyId')
                    ->label(__('message.DeliveryBoyId'))
                    ->prefixIcon('heroicon-o-key')
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->prefixIcon('heroicon-m-user')
                    ->label(__('message.Name'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('mobile')
                    ->label(__('message.Phone Number'))
                    ->prefixIcon('heroicon-m-phone')
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->label(__('message.Address'))
                    ->prefixIcon('heroicon-m-map-pin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('plate_number')
                    ->label(__('message.License plate'))
                    ->required()
                    ->prefixIcon('heroicon-o-wallet')
                    ->maxLength(255),
                Forms\Components\TextInput::make('location')
                    ->label(__('message.Location'))
                    ->prefixIcon('heroicon-m-map-pin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('lat')
                    ->label(__('message.Lat'))
                    ->maxLength(255),
                Forms\Components\TextInput::make('long')
                    ->label(__('message.Long'))
                    ->maxLength(255),
                Forms\Components\Toggle::make('status')
                    ->label(__('message.Status'))
                    ->default('1')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success'),
                Forms\Components\Toggle::make('available_for_delivery')
                    ->label(__('message.Available for delivery'))
                    ->default('0')
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('riderBoyId')
                    ->label(__('message.DeliveryBoyId'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('message.Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile')
                    ->label(__('message.Phone Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('riderLoginData.email')
                    ->label(__('message.Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('plate_number')
                    ->label(__('message.License plate'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('message.Address'))
                    ->searchable(),
                // TextColumn::make('location')
                //     ->label(__('message.Location'))
                //     ->state(__('message.View location')) // text shown in table
                //     ->url(fn ($record) => $record->location) // your stored URL / lat,lng link
                //     ->icon('heroicon-m-map-pin')
                //     ->color('danger')
                //     ->openUrlInNewTab()
                //     ->searchable(false),
                TextColumn::make('location')
                    ->label(__('message.Location'))
                    ->state(__('message.View location')) // text shown in table
                    ->url(fn ($record) =>
                        ($record->lat && $record->long)
                            ? "https://www.google.com/maps?q={$record->lat},{$record->long}"
                            : null
                    )
                    ->icon('heroicon-m-map-pin')
                    ->color('success')
                    ->openUrlInNewTab(),
                Tables\Columns\IconColumn::make('status')
                    ->label(__('message.Status'))
                    ->boolean(),
                Tables\Columns\IconColumn::make('available_for_delivery')
                    ->label(__('message.Available for delivery'))
                    ->boolean(),
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
                // Tables\Actions\ViewAction::make()->label(__('message.View'))->modalHeading(__('message.View')),
                Tables\Actions\EditAction::make()->label(__('message.Edit'))->modalButton(__('message.Save changes')),
                Tables\Actions\DeleteAction::make()->label(__('message.Delete')),
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
            'index' => Pages\ListRiders::route('/'),
            // 'create' => Pages\CreateRider::route('/create'),
            // 'view' => Pages\ViewRider::route('/{record}'),
            // 'edit' => Pages\EditRider::route('/{record}/edit'),
        ];
    }
}
