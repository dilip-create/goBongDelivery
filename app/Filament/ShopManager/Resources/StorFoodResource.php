<?php

namespace App\Filament\ShopManager\Resources;

use App\Filament\ShopManager\Resources\StorFoodResource\Pages;
use App\Filament\ShopManager\Resources\StorFoodResource\RelationManagers;
use App\Models\StorFood;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\User;
use App\Models\Stor;
use App\Models\Category;
use App\Models\Currency;
use Filament\Tables\Columns\ImageColumn;

class StorFoodResource extends Resource
{
    protected static ?string $model = StorFood::class;

    public static function getNavigationGroup(): ?string{
        return __('message.Menu Management');
    }
    public static function getModelLabel(): string{
        return __('message.Food menu');
    }
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('storLoginId')
                    ->default(fn () => User::where('id', auth()->id())->value('id'))
                    ->dehydrated(true) // ensure it's saved to DB
                    ->required(),
                Forms\Components\Hidden::make('stor_id')
                    ->default(fn () => Stor::where('storLoginId', auth()->id())->value('id'))
                    ->dehydrated(true) // ensure it's saved to DB
                    ->required(),
                Forms\Components\Select::make('category_id')
                    ->label(__('message.Select Category'))
                    ->options(Category::getSellerOptions())
                    ->prefixIcon('heroicon-o-tag')
                    ->searchable()
                    ->required(),
                

                Forms\Components\TextInput::make('food_name')
                    ->label(__('message.Food name'))
                    ->required()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Select::make('currency_id')
                    ->label(__('message.Currency'))
                    ->options(Currency::where('deleted_at', NULL)->pluck('currency_code', 'id'))
                    ->prefixIcon('heroicon-o-currency-dollar')
                    ->required()
                    ->default(3)
                    ->reactive(),
                Forms\Components\TextInput::make('ordering')
                    ->label(__('message.Sequence'))
                    ->numeric()
                    ->prefixIcon('heroicon-o-adjustments-horizontal')
                    ->default(null),
                Forms\Components\TextInput::make('cost_price')
                    ->label(__('message.Cost Price'))
                    ->required()
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Get GP % (shop_commission) of the logged-in shop
                        $stor = Stor::where('storLoginId', auth()->id())->first();
                        $gp = $stor?->shop_commission ?? 0;

                        // Calculate selling price using GP formula
                        // Formula: selling_price = cost_price / (1 - GP%)
                        if ($gp > 0 && $gp < 100 && $state > 0) {
                            $sellingPrice = $state / (1 - ($gp / 100));

                            // Round up to nearest whole number
                            $sellingPrice = ceil($sellingPrice);

                            // Set calculated value
                            $set('selling_price', (int) $sellingPrice);
                        } else {
                            $set('selling_price', null);
                        }
                    }),
                Forms\Components\TextInput::make('selling_price')
                    ->label(__('message.Selling Price (Calculated by GP)'))
                    ->required()
                    ->numeric()
                    ->maxLength(255)
                    ->default(null), 
                Forms\Components\Select::make('trending_status')
                            ->label(__('message.Show trending or popular'))
                            ->options([
                                '1' => __('message.Yes'),
                                '0' => __('message.No'),
                            ])
                            ->prefixIcon('heroicon-o-arrow-trending-up')
                            ->default('0'),
                Forms\Components\FileUpload::make('food_img')
                    ->label(__('message.Food Image'))
                    ->required()
                    ->directory('images/restaurant/food')
                    ->image(),
                Forms\Components\Toggle::make('status')
                    ->label(__('message.Status'))
                    ->default(1)
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->owner()) 
            ->columns([
                Tables\Columns\TextColumn::make('getCategoryData.cat_name')
                    ->label(__('message.Category Name or Menu name'))
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('food_name')
                    ->label(__('message.Food name'))
                    ->searchable(),
                Tables\Columns\ImageColumn::make('food_img')
                    ->label(__('message.Food Image'))
                    ->circular() 
                    ->height('80px') 
                    ->width('100px'),
                Tables\Columns\TextColumn::make('cost_price')
                    ->label(__('message.Cost Price'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('selling_price')
                    ->label(__('message.Selling Price (Calculated by GP)'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label(__('message.Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $state == '1' ? 'Open' : 'turn off')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                    }),
                Tables\Columns\IconColumn::make('trending_status')
                    ->label(__('message.Show trending or popular'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('ordering')
                    ->label(__('message.Sequence'))
                    ->searchable(),
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
            'index' => Pages\ListStorFood::route('/'),
            // 'create' => Pages\CreateStorFood::route('/create'),
            // 'view' => Pages\ViewStorFood::route('/{record}'),
            // 'edit' => Pages\EditStorFood::route('/{record}/edit'),
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
