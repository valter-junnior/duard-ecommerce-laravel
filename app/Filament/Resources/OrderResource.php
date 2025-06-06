<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatus;
use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariation;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use App\Models\ShippingAddress;
use App\Traits\HasMenuConfig;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    use HasMenuConfig;

    protected static ?string $model = Order::class;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('client_id')
                ->label('Cliente')
                ->relationship('client', 'id')
                ->getOptionLabelFromRecordUsing(fn($record) => $record->user->name ?? '—')
                ->searchable()
                ->preload()
                ->required()
                ->reactive()
                ->afterStateUpdated(function (Set $set) {
                    $set('shipping_address_id', null); // limpa o campo dependente
                }),

            Select::make('shipping_address_id')
                ->label('Endereço de Entrega')
                ->disabled(fn(Get $get) => empty($get('client_id')))
                ->options(function (Get $get) {
                    $clientId = $get('client_id');

                    if (!$clientId) {
                        return [];
                    }

                    return ShippingAddress::where('client_id', $clientId)
                        ->get()
                        ->mapWithKeys(fn($address) => [
                            $address->id => "{$address->postal_code}, {$address->address}, Nº {$address->number}"
                        ])
                        ->toArray();
                })
                ->searchable()
                ->preload()
                ->required()
                ->reactive(),

            Select::make('status')
                ->label('Status do Pedido')
                ->options(OrderStatus::options())
                ->default(OrderStatus::PENDING->value)
                ->required(),

            TextInput::make('total_amount')
                ->label('Total')
                ->prefix('R$')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->reactive(),

            Repeater::make('items')
                ->label('Itens do Pedido')
                ->relationship('items')
                ->minItems(1)
                ->afterStateUpdated(function (callable $set, $state) {
                    $total = collect($state)
                        ->sum(
                            fn($item) => ((int) $item['quantity'] ?? 0) * ((float) $item['unit_price'] ?? 0)
                        );

                    $set('total_amount', number_format($total, 2, '.', ''));
                })
                ->schema([
                    Select::make('product_id')
                        ->label('Produto')
                        ->options(Product::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required()
                        ->reactive()
                        ->columnSpan(1)
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            $product = Product::find($state);
                            $variationId = $get('variation_id');
                            $variation = $variationId ? ProductVariation::find($variationId) : null;

                            $price = $variation && $variation->price !== null
                                ? $variation->price
                                : ($product->price ?? 0);

                            $set('unit_price', number_format($price, 2, '.', ''));
                        }),

                    Select::make('variation_id')
                        ->label('Variação')
                        ->options(function (Get $get) {
                            if (!$get('product_id')) return [];
                            return ProductVariation::where('product_id', $get('product_id'))
                                ->get()
                                ->mapWithKeys(fn($variation) => [
                                    $variation->id => $variation->name ?? 'Variação #' . $variation->id,
                                ])
                                ->toArray();
                        })
                        ->searchable()
                        ->nullable()
                        ->reactive()
                        ->columnSpan(1)
                        ->afterStateUpdated(function (Set $set, Get $get, $state) {
                            $product = Product::find($get('product_id'));
                            $variation = $state ? ProductVariation::find($state) : null;

                            $price = $variation && $variation->price !== null
                                ? $variation->price
                                : ($product->price ?? 0);

                            $set('unit_price', number_format($price, 2, '.', ''));
                        }),

                    TextInput::make('quantity')
                        ->label('Quantidade')
                        ->numeric()
                        ->required()
                        ->reactive()
                        ->columnSpan(1)
                        ->default(1),

                    TextInput::make('unit_price')
                        ->label('Preço Unitário')
                        ->numeric()
                        ->prefix('R$')
                        ->required()
                        ->disabled()
                        ->reactive()
                        ->columnSpan(1),
                ])
                ->columns(4)
                ->itemLabel(function (array $state): string {
                    $product = Product::find($state['product_id'] ?? null);
                    $variation = ProductVariation::find($state['variation_id'] ?? null);

                    $productName = $product?->name ?? 'Produto';
                    $variationLabel = $variation?->name ?? 'sem variação';

                    return "{$productName} - {$variationLabel}";
                })
                ->defaultItems(1)
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.user.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn(OrderStatus $state) => $state->label())
                    ->color(fn(OrderStatus $state): string => match ($state) {
                        OrderStatus::PENDING   => 'warning',
                        OrderStatus::PAID      => 'success',
                        OrderStatus::SHIPPED   => 'info',
                        OrderStatus::DELIVERED => 'info',
                        OrderStatus::CANCELED  => 'danger',
                        OrderStatus::RETURNED  => 'gray',
                        default                       => 'gray',
                    })
                    ->sortable(),

                TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('BRL')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
