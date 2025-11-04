<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PopupResource\Pages;
use App\Filament\Resources\PopupResource\RelationManagers;
use App\Models\Popup;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\ImageColumn;

class PopupResource extends Resource
{
    protected static ?string $model = Popup::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function getModelLabel(): string{
        return __('message.Popup');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('popup_img')
                    ->label(__('message.Image'))
                    ->required()
                    ->directory('images/popup')
                    ->image(),
                Forms\Components\TextInput::make('ordering')
                    ->label(__('message.Sequence'))
                    ->numeric()
                    ->prefixIcon('heroicon-o-adjustments-horizontal')
                    ->default(null),
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
            ->columns([
                Tables\Columns\ImageColumn::make('popup_img')
                    ->label(__('message.Image'))
                    ->circular() 
                    ->height('80px') 
                    ->width('100px'),
                Tables\Columns\TextColumn::make('ordering')
                    ->label(__('message.Sequence'))
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
            ->defaultSort('ordering', 'asc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPopups::route('/'),
            // 'create' => Pages\CreatePopup::route('/create'),
            // 'view' => Pages\ViewPopup::route('/{record}'),
            // 'edit' => Pages\EditPopup::route('/{record}/edit'),
        ];
    }
}
