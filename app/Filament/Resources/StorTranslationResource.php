<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StorTranslationResource\Pages;
use App\Filament\Resources\StorTranslationResource\RelationManagers;
use App\Models\StorTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Language;
use App\Models\Stor;
use Filament\Tables\Columns\ImageColumn;


class StorTranslationResource extends Resource
{
    protected static ?string $model = StorTranslation::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    public static function getNavigationGroup(): ?string{
        return __('message.Restaurant Management');
    }
    public static function getModelLabel(): string{
        return __('message.Restaurant Translation');
    }
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('stor_id')
                    ->label(__('message.Restaurant ID'))
                    ->options(Stor::where('openStatus', 1)->pluck('id', 'id')) 
                    ->prefix('restaurant_')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->label(__('message.Select language'))
                    ->options(Language::where('status', 1)->pluck('name', 'id')) 
                    ->prefixIcon('heroicon-o-flag')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('stor_name')
                    ->label(__('message.Shop name'))
                    ->prefixIcon('heroicon-m-arrow-long-right')
                    ->rule(function ($record) {
                        return $record ? 'unique:stor_translations,stor_name,' . $record->id : 'unique:stor_translations,stor_name';
                    })
                    ->required()
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('desc')
                    ->label(__('message.Description'))
                    ->prefixIcon('heroicon-m-arrow-long-right')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('address')
                    ->label(__('message.Address'))
                    ->prefixIcon('heroicon-m-arrow-long-right')
                    ->maxLength(255)
                    ->required()
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
               
                Tables\Columns\TextColumn::make('stor_id')
                    ->getStateUsing(fn ($record)=> 'restaurant_'.$record->stor_id)
                    ->label(__('message.Restaurant ID'))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\ImageColumn::make('getstorData.stor_photo')
                    ->label(__('message.Shop Image'))
                    ->circular() // disable circle
                    ->height('100px') // set height
                    ->width('100px'),  // set width
                Tables\Columns\TextColumn::make('languages.name')
                    ->label(__('message.Language'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('stor_name')
                    ->label(__('message.Shop name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('desc')
                    ->label(__('message.Description'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->label(__('message.Address'))
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
            'index' => Pages\ListStorTranslations::route('/'),
            // 'create' => Pages\CreateStorTranslation::route('/create'),
            // 'view' => Pages\ViewStorTranslation::route('/{record}'),
            // 'edit' => Pages\EditStorTranslation::route('/{record}/edit'),
        ];
    }
}
