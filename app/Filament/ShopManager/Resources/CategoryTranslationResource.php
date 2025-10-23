<?php

namespace App\Filament\ShopManager\Resources;

use App\Filament\ShopManager\Resources\CategoryTranslationResource\Pages;
use App\Filament\ShopManager\Resources\CategoryTranslationResource\RelationManagers;
use App\Models\CategoryTranslation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use App\Models\Language;
use App\Models\Category;

class CategoryTranslationResource extends Resource
{
    protected static ?string $model = CategoryTranslation::class;

    // protected static ?string $navigationIcon = 'heroicon-o-tag';
    public static function getNavigationGroup(): ?string{
        return __('message.Menu Management');
    }
    public static function getModelLabel(): string{
        return __('message.Category Translation');
    }
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->label(__('message.Select Category'))
                    ->options(Category::getSellerOptions())
                    ->prefixIcon('heroicon-o-tag')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('language_id')
                    ->label(__('message.Select language'))
                    ->options(Language::where('status', 1)->pluck('name', 'id')) 
                    ->prefixIcon('heroicon-o-flag')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('cat_translation_name')
                    ->label(__('message.Category Translation Name'))
                    ->prefixIcon('heroicon-o-tag')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('cat_desc')
                    ->label(__('message.Description'))
                    ->maxLength(255)
                    ->default(null),
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
                Tables\Columns\TextColumn::make('languages.name')
                    ->label(__('message.Language'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_translation_name')
                    ->label(__('message.Category Translation Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('cat_desc')
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
            'index' => Pages\ListCategoryTranslations::route('/'),
            // 'create' => Pages\CreateCategoryTranslation::route('/create'),
            // 'view' => Pages\ViewCategoryTranslation::route('/{record}'),
            // 'edit' => Pages\EditCategoryTranslation::route('/{record}/edit'),
        ];
    }
}
