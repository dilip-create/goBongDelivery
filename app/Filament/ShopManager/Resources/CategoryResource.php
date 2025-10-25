<?php

namespace App\Filament\ShopManager\Resources;

use App\Filament\ShopManager\Resources\CategoryResource\Pages;
use App\Filament\ShopManager\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Stor;
use Filament\Tables\Columns\ImageColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    // protected static ?string $navigationIcon = 'heroicon-o-tag';
    public static function getNavigationGroup(): ?string{
        return __('message.Menu Management');
    }
    public static function getModelLabel(): string{
        return __('message.Category');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('cat_name')
                    ->label(__('message.Category Name or Menu name'))
                    ->required()
                    ->prefixIcon('heroicon-o-tag')
                    ->maxLength(255),
                // Forms\Components\TextInput::make('stor_id')
                //     ->label(__('message.Shop name'))
                //     ->prefixIcon('heroicon-o-building-storefront')
                //     ->default(fn () => auth()->user()->name) // For create
                //     ->formatStateUsing(function ($state) {
                //         // For edit -> show the shop name instead of ID
                //         return Stor::find($state)?->cuisine ?? auth()->user()->name;
                //     })
                //     ->dehydrateStateUsing(function ($state) {
                //         // Always save stor_id in DB
                //         return Stor::where('storLoginId', auth()->id())->value('id');
                //     })
                //     ->readOnly()
                //     ->required(),
                Forms\Components\Hidden::make('stor_id')
                    ->default(fn () => Stor::where('storLoginId', auth()->id())->value('id'))
                    ->dehydrated(true) // ensure it's saved to DB
                    ->required(),

                Forms\Components\TextInput::make('ordering')
                    ->label(__('message.Sequence'))
                    ->numeric()
                    ->prefixIcon('heroicon-o-adjustments-horizontal')
                    ->default(null),
                Forms\Components\Select::make('trending_status')
                            ->label(__('message.Show trending or popular'))
                            ->options([
                                '1' => __('message.Yes'),
                                '0' => __('message.No'),
                            ])
                            ->prefixIcon('heroicon-o-arrow-trending-up')
                            ->default('0'),
                Forms\Components\Toggle::make('cat_status')
                    ->label(__('message.Status'))
                    ->default(1)
                    ->onIcon('heroicon-m-bolt')
                    ->offIcon('heroicon-m-user')
                    ->onColor('success'),
                //  Forms\Components\FileUpload::make('cat_image')
                //     ->label(__('message.Image'))
                //     ->required()
                //     ->directory('images/categories')
                //     ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->owner()) 
            ->columns([
                Tables\Columns\TextColumn::make('Serial_number')
                    ->label(__('message.Serial number'))
                    ->badge()
                    ->state(fn($column) => $column->getRowLoop()->iteration),
                Tables\Columns\TextColumn::make('cat_name')
                    ->label(__('message.Category Name or Menu name'))
                    ->searchable(),
                // Tables\Columns\ImageColumn::make('cat_image')
                //     ->label(__('message.Image'))
                //     ->circular() // disable circle
                //     ->height('80px') // set height
                //     ->width('80px'),  // set width
                Tables\Columns\TextColumn::make(auth()->user()->name)
                    ->label(__('message.Shop name'))
                    ->default(fn () => auth()->user()->name),
                Tables\Columns\TextColumn::make('ordering')
                    ->label(__('message.Sequence'))
                    ->searchable(),
                Tables\Columns\IconColumn::make('trending_status')
                    ->label(__('message.Show trending or popular'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('cat_status')
                    ->label(__('message.Open Status'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => $state == '1' ? 'Publish' : 'Waiting for verification')
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
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(__('message.View'))->modalHeading(__('message.View')),
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
            'index' => Pages\ListCategories::route('/'),
            // 'create' => Pages\CreateCategory::route('/create'),
            // 'view' => Pages\ViewCategory::route('/{record}'),
            // 'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
