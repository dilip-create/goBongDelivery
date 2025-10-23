<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorResource\Pages;
use App\Filament\Resources\StorResource\RelationManagers;
use App\Models\Stor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\User;
use Filament\Tables\Columns\ImageColumn;


class StorResource extends Resource
{
    protected static ?string $model = Stor::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    public static function getNavigationGroup(): ?string{
        return __('message.Restaurant Management');
    }
    public static function getModelLabel(): string{
        return __('message.Restaurant');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make(__('message.Shop information'))
                    ->schema([
                        Forms\Components\Select::make('storLoginId')
                            ->label(__('message.Shop Manager'))
                            ->options(
                                User::where('role', 'Shop Manager')->orderByDesc('id')
                                    ->get()
                                    ->mapWithKeys(function ($seller) {
                                        return [$seller->id => ucfirst($seller->name) . ' => ' . $seller->phoneNumber];
                                    })
                                    ->toArray()
                            )
                            ->prefixIcon('heroicon-o-tag')
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('area')
                            ->label(__('message.Area'))
                            ->options([
                                'Go Bong Delivery' => 'Go Bong Delivery',
                            ])
                            ->prefixIcon('heroicon-m-map-pin')
                            ->default('Go Bong Delivery')
                            ->required(),
                        Forms\Components\Select::make('stor_type')
                            ->label(__('message.Shop Type'))
                            ->options([
                                'Restaurant' => __('message.Restaurant'),
                                'Shop' => __('message.Shop'),
                                'Mart' => __('message.Mart'),
                                'Laundry' => __('message.Laundry'),
                            ])
                            ->prefixIcon('heroicon-o-building-office')
                            ->required(),
                        Forms\Components\Select::make('cuisine')
                            ->label(__('message.Cuisine'))
                            ->options([
                                'Khmer food' => __('message.Khmer food'),
                                'Thai food' => __('message.Thai food'),
                                'Japanese food' => __('message.Japanese food'),
                                'Chinese food' => __('message.Chinese food'),
                                'Drink' => __('message.Drink'),
                                'Fruit' => __('message.Fruit'),
                                'Beauty' => __('message.Beauty'),
                                'Clothes' => __('message.Clothes'),
                                'Supermarket' => __('message.Supermarket'),
                                'Ice Cream' => __('message.Ice Cream'),
                            ])
                            ->prefixIcon('heroicon-m-bookmark-square')
                            ->required(),
                        Forms\Components\FileUpload::make('stor_photo')
                                    ->label(__('message.Shop Image'))
                                    ->required()
                                    ->directory('images/restaurant')
                                    ->image(),
                        Forms\Components\TextInput::make('stor_mobile')
                            ->label(__('message.Phone Number'))
                            ->tel()
                            ->prefixIcon('heroicon-m-phone')
                            ->required()
                            ->rule(function ($record) {
                                return $record ? 'unique:stors,stor_mobile,' . $record->id : 'unique:stors,stor_mobile';
                            })
                            ->maxLength(12),
                 ])->columns(2),
                
                Forms\Components\Section::make(__('message.Shop Timing'))
                    ->schema([
                        Forms\Components\TimePicker::make('opentime')
                            ->label(__('message.Shop opening time'))
                            ->required()
                            ->prefixIcon('heroicon-m-play'),
                        Forms\Components\TimePicker::make('closetime')
                            ->label(__('message.Shop closed time'))
                            ->required()
                            ->prefixIcon('heroicon-m-play'),
                    ])->columns(2),

                Forms\Components\Select::make('commission_type')
                    ->label(__('message.Select commission type'))
                    ->options([
                        'Set the shop GP deduction method' => __('message.Set the shop GP deduction method'),
                        'Add food costs to the cost price' => __('message.Add food costs to the cost price'),
                        'Set GP and price from cost' => __('message.Set GP and price from cost'),
                    ])
                    ->prefixIcon('heroicon-m-document-currency-dollar')
                    ->required(),
                Forms\Components\TextInput::make('shop_commission')
                    ->label(__('message.Shop commission (%)'))
                    ->prefixIcon('heroicon-m-chevron-double-right')
                    ->numeric()       // ensures input is numeric
                    ->maxLength(255),
                Forms\Components\TextInput::make('stor_lat')
                    ->label(__('message.Lat'))
                    ->prefixIcon('heroicon-m-map-pin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('stor_long')
                    ->label(__('message.Long'))
                    ->prefixIcon('heroicon-m-map-pin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('openStatus')
                    ->label(__('message.Open Status'))
                    ->default(1)
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success'),
                Forms\Components\TextInput::make('distance_from_office')
                    ->label(__('message.Distance form Go Bong office in meter'))
                    ->maxLength(255)
                    ->prefixIcon('heroicon-m-map-pin')
                    ->default(null),
               
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
                Tables\Columns\TextColumn::make('getshopManager.name')
                    ->label(__('message.Shop Manager'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('id')
                    ->label(__('message.Restaurant ID'))
                    ->getStateUsing(fn ($record)=> 'restaurant_'.$record->id)
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('stor_photo')
                    ->label(__('message.Shop Image'))
                    ->circular(false) // disable circle
                    ->height('120px') // set height
                    ->width('200px')  // set width
                    ->extraImgAttributes([
                        'class' => 'object-cover rounded-md', // optional: cover + rounded rectangle
                    ]),
                Tables\Columns\TextColumn::make('stor_type')
                    ->label(__('message.Shop Type'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cuisine')
                    ->label(__('message.Cuisine'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('stor_mobile')
                    ->label(__('message.Phone Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('opentime')
                    ->searchable(),
                Tables\Columns\TextColumn::make('closetime')
                    ->searchable(),
                Tables\Columns\TextColumn::make('distance_from_office')
                    ->getStateUsing(fn ($record)=> $record->distance_from_office.' km')
                    ->searchable(),
                Tables\Columns\TextColumn::make('openStatus')
                    ->label(__('message.Open Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Open' : 'Closed')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('message.Created at'))
                    ->dateTime('d-M-Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->label(__('message.Deleted at'))
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('message.Updated at'))
                    ->dateTime('d-M-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(__('message.View'))->modalHeading(__('message.View')),
                Tables\Actions\EditAction::make()->label(__('message.Edit'))->modalButton(__('message.Save changes')),
                Tables\Actions\DeleteAction::make()->label(__('message.Delete')),
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
            'index' => Pages\ListStors::route('/'),
            // 'create' => Pages\CreateStor::route('/create'),
            // 'view' => Pages\ViewStor::route('/{record}'),
            // 'edit' => Pages\EditStor::route('/{record}/edit'),
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
