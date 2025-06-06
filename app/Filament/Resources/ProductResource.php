<?php

namespace App\Filament\Resources;

use App\Filament\Components\Forms\AppForm;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use App\Traits\HasMenuConfig;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    use HasMenuConfig;

    protected static ?string $model = Product::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                AppForm::make([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('Nome'),

                    Forms\Components\Textarea::make('description')
                        ->label('Descrição')
                        ->columnSpanFull(),

                    Forms\Components\FileUpload::make('photos')
                        ->label('Fotos do Produto')
                        ->multiple()
                        ->image()
                        ->maxSize(250)
                        ->panelLayout('grid')
                        ->reorderable()
                        ->directory('products/images')
                        ->preserveFilenames()
                        ->columnSpanFull(),

                    Forms\Components\Repeater::make('variations')
                        ->relationship('variations')
                        ->label('Variações')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label('Nome da Variação')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->maxLength(100)
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('stock')
                                ->label('Estoque')
                                ->numeric()
                                ->minValue(0)
                                ->required()
                                ->columnSpan(1),

                            Forms\Components\TextInput::make('price')
                                ->label('Preço')
                                ->numeric()
                                ->prefix('R$')
                                ->columnSpan(1),
                        ])
                        ->defaultItems(1)
                        ->columns(4)
                        ->collapsible()
                        ->itemLabel(fn(array $state): ?string => $state['name'] ?? 'Nova Variação')
                        ->columnSpanFull(),
                ], [
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->label('Categoria')
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('price')
                        ->label('Preço')
                        ->numeric()
                        ->prefix('R$')
                        ->required(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->label('Produto'),
                Tables\Columns\TextColumn::make('category.name')->label('Categoria'),
                Tables\Columns\TextColumn::make('price')->money('BRL'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
