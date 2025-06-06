<?php

namespace App\Filament\Resources;

use App\Filament\Components\Forms\AppForm;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Leandrocfe\FilamentPtbrFormFields\Money;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationLabel = 'Produtos';
    protected static ?string $pluralModelLabel = 'Produtos';

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
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('sku')
                                ->label('SKU')
                                ->required()
                                ->maxLength(100)
                                ->columnSpan(2),

                            Forms\Components\TextInput::make('stock')
                                ->label('Estoque')
                                ->numeric()
                                ->minValue(0)
                                ->required()
                                ->columnSpan(1),
                        ])
                        ->defaultItems(1)
                        ->columns(5)
                        ->collapsible()
                        ->itemLabel(fn (array $state): ?string => $state['name'] ?? 'Nova Variação')
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
                Tables\Actions\EditAction::make()   ,
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
