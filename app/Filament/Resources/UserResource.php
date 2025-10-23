<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    public static function getNavigationGroup(): ?string{
        return __('message.Admin Management');
    }
    public static function getModelLabel(): string{
        return __('message.Users');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(__('message.Name'))
                    ->prefixIcon('heroicon-o-user')
                    ->required()
                    ->rule(function ($record) {
                        return $record ? 'unique:users,name,' . $record->id : 'unique:users,name';
                    })
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label(__('message.Email'))
                    ->prefixIcon('heroicon-m-envelope')
                    ->email()
                    ->rule(function ($record) {
                        return $record ? 'unique:users,email,' . $record->id : 'unique:users,email';
                    })
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phoneNumber')
                    ->label(__('message.Phone Number'))
                    ->tel()
                    ->prefixIcon('heroicon-m-phone')
                    ->required()
                    ->rule(function ($record) {
                        return $record ? 'unique:users,phoneNumber,' . $record->id : 'unique:users,phoneNumber';
                    })
                    ->maxLength(12),
                Forms\Components\TextInput::make('password')
                    ->label(__('message.Password'))
                    ->password()
                    ->revealable()
                    ->prefixIcon('heroicon-m-lock-closed')
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->label(__('message.Role'))
                    ->options([
                            'Admin' => __('message.Admin'),
                            'Shop Manager' => __('message.Shop Manager'),
                            'Rider' => __('message.Rider'),
                        ])
                    ->default('admin')
                    ->prefixIcon('heroicon-m-flag')
                    ->required(),
                Forms\Components\Toggle::make('email_verified_at')
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
                Tables\Columns\TextColumn::make('Serial_number')
                ->label(__('message.Serial number'))
                ->badge()
                ->state(fn($column) => $column->getRowLoop()->iteration),
                Tables\Columns\TextColumn::make('name')
                    ->label(__('message.Name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label(__('message.Email'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('phoneNumber')
                    ->label(__('message.Phone Number'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('role')
                    ->label(__('message.Role'))
                    ->searchable()
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Rider' => 'warning',
                        'Admin' => 'success',
                        'Shop Manager' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->label(__('message.Status'))
                    ->formatStateUsing(fn (string $state): string => $state === '1' ? 'Active' : 'Block')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        '0' => 'danger',
                        '1' => 'success',
                    })
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
            ->filters([
                // Tables\Filters\TrashedFilter::make(),
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // return parent::getEloquentQuery()
        //     ->withoutGlobalScopes([
        //         SoftDeletingScope::class,
        //     ]);
            return parent::getEloquentQuery();
    }
}
