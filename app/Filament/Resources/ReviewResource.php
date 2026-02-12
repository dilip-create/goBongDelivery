<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Resources\Tables\Actions\Action;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Models\Customer;
use Illuminate\Support\Str;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    public static function getNavigationGroup(): ?string{
        return __('message.Order Management');
    }
    public static function getModelLabel(): string{
        return __('message.Customer Reviews');
    }
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('order_key')
                    ->maxLength(255)
                    ->label(__('message.Order'))
                    ->disabled()
                    ->prefixIcon('heroicon-o-tag'),
                Forms\Components\Select::make('cust_id')
                    ->label(__('message.Customer name'))
                    ->options(
                        Customer::orderByDesc('id')
                            ->get()
                            ->mapWithKeys(function ($customer) {
                                return [$customer->id => ucfirst($customer->name) . ' => ' . $customer->phoneNumber];
                            })
                            ->toArray()
                    )
                    ->prefixIcon('heroicon-m-user')
                    ->required()
                    ->disabledOn('edit'),
                Forms\Components\TextInput::make('rating')
                    ->label(__('message.Rating'))
                    ->maxLength(255)
                    ->prefixIcon('heroicon-m-star')
                    ->required()
                    ->default(null),
                Forms\Components\Textarea::make('desc')
                    ->label(__('message.Description'))
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
                // ExportAction::make()
                ExportAction::make()->label(__('message.Export'))->exports([
                    ExcelExport::make()->fromTable()->except([
                        'Serial_number', 'updated_at',
                    ]),
                    // ExcelExport::make()->fromTable()->only([
                    //     'email', 'phone',
                    // ]),
                ])
            ])
            ->columns([
                Tables\Columns\TextColumn::make('Serial_number')
                    ->label(__('message.Serial number'))
                    ->badge()
                    ->state(fn($column) => $column->getRowLoop()->iteration),
                Tables\Columns\TextColumn::make('order_key')
                    ->label(__('message.Order'))
                    ->badge()
                    ->color('warning')
                    ->searchable(),
                Tables\Columns\TextColumn::make('getstorTranslation.stor_name')
                    ->label(__('message.Store name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('combinessd')
                    ->label(__('message.Customer name'))
                    ->html()
                    ->getStateUsing(fn ($record) =>
                        '<strong>' . Str::ucfirst($record->getCustomerdata->name) . '</strong><br>' .
                        Str::ucfirst($record->getCustomerdata->phoneNumber)
                    ),
                // Tables\Columns\TextColumn::make('rating')
                //     ->label(__('message.Rating'))
                //     ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label(__('message.Rating'))
                    ->formatStateUsing(function ($state) {
                        return str_repeat('⭐', (int) $state);
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('desc')
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
            'index' => Pages\ListReviews::route('/'),
            // 'create' => Pages\CreateReview::route('/create'),
            // 'view' => Pages\ViewReview::route('/{record}'),
            // 'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
