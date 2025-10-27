<?php

namespace App\Filament\ShopManager\Resources;

use App\Filament\ShopManager\Resources\StorFoodTranslationResource\Pages;
use App\Filament\ShopManager\Resources\StorFoodTranslationResource\RelationManagers;
use App\Models\StorFoodTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Language;
use App\Models\StorFood;
use Filament\Tables\Columns\ImageColumn;

class StorFoodTranslationResource extends Resource
{
    protected static ?string $model = StorFoodTranslation::class;

    public static function getNavigationGroup(): ?string{
        return __('message.Menu Management');
    }
    public static function getModelLabel(): string{
        return __('message.Food menu translation');
    }
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('stor_food_id')
                    ->label(__('message.Select food'))
                    ->options(StorFood::getFoodnameOptions())
                    ->prefixIcon('heroicon-o-tag')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->label(__('message.Select language'))
                    ->options(Language::where('status', 1)->pluck('name', 'id')) 
                    ->prefixIcon('heroicon-o-flag')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('food_translation_name')
                    ->label(__('message.Food Translation Name'))
                    ->prefixIcon('heroicon-o-tag')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('food_desc')
                    ->label(__('message.Description'))
                    ->prefixIcon('heroicon-o-adjustments-horizontal')
                    ->maxLength(255)
                    ->default(null),
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
                Tables\Columns\TextColumn::make('getFoodData.food_name')
                    ->label(__('message.Food name'))
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('getFoodData.food_img')
                    ->label(__('message.Image'))
                    ->circular() 
                    ->height('80px') 
                    ->width('100px'),
                Tables\Columns\TextColumn::make('languages.name')
                    ->label(__('message.Language'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('food_translation_name')
                    ->label(__('message.Food Translation Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('food_desc')
                    ->label(__('message.Description'))
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
            'index' => Pages\ListStorFoodTranslations::route('/'),
            // 'create' => Pages\CreateStorFoodTranslation::route('/create'),
            // 'view' => Pages\ViewStorFoodTranslation::route('/{record}'),
            // 'edit' => Pages\EditStorFoodTranslation::route('/{record}/edit'),
        ];
    }
}
