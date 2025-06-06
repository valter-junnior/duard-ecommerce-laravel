<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use App\Models\User;
use App\Traits\HasMenuConfig;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Leandrocfe\FilamentPtbrFormFields\Cep;
use Leandrocfe\FilamentPtbrFormFields\Document;
use Leandrocfe\FilamentPtbrFormFields\PhoneNumber;

class ClientResource extends Resource
{
    use HasMenuConfig;

    protected static ?string $model = Client::class;

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Fieldset::make('Dados')
                ->schema([
                    TextInput::make('name')
                        ->label('Nome')
                        ->placeholder('Digite o nome completo')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull()
                        ->autofocus(),

                    Document::make('document')
                        ->label('CPF/CNPJ')
                        ->dynamic()
                        ->unique(column: 'document', ignoreRecord: true)
                        ->columnSpan(1),

                    PhoneNumber::make('phone_number')
                        ->label('Telefone')
                        ->columnSpan(1),
                ])
                ->columns(2),


            Forms\Components\Section::make('Endereços de Entrega')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Forms\Components\Repeater::make('shippingAddresses')
                        ->relationship('shippingAddresses')
                        ->label('')
                        ->addActionLabel('Adicionar Endereço')
                        ->schema([
                            Forms\Components\Hidden::make('id'),

                            Cep::make('postal_code')
                                ->label('CEP')
                                ->viaCep(
                                    mode: 'suffix',
                                    errorMessage: 'CEP inválido.',
                                    setFields: [
                                        'address' => 'logradouro',
                                        'district' => 'bairro',
                                        'city' => 'localidade',
                                        'state' => 'uf'
                                    ]
                                )
                                ->columnSpan(1),

                            TextInput::make('address')
                                ->label('Endereço')
                                ->maxLength(255)
                                ->columnSpan(3),

                            TextInput::make('number')
                                ->label('Número')
                                ->maxLength(10)
                                ->columnSpan(1),

                            TextInput::make('complement')
                                ->label('Complemento')
                                ->maxLength(255)
                                ->columnSpan(3),

                            TextInput::make('state')
                                ->label('Estado')
                                ->columnSpan(1),

                            TextInput::make('city')
                                ->label('Cidade')
                                ->maxLength(255)
                                ->columnSpan(1),

                            TextInput::make('district')
                                ->label('Bairro')
                                ->maxLength(255)
                                ->columnSpan(2),
                        ])
                        ->columns(4)
                        ->defaultItems(1)
                        ->collapsible()
                        ->collapsed()
                        ->itemLabel(
                            fn(array $state): string =>
                            isset($state['postal_code'], $state['address'], $state['number'])
                                ? "{$state['postal_code']}, {$state['address']}, Nº {$state['number']}"
                                : 'Novo Endereço'
                        )
                        ->columnSpanFull(),
                ]),

            Fieldset::make('Acesso')
                ->schema([
                    TextInput::make('email')
                        ->label('E-mail')
                        ->placeholder('exemplo@dominio.com')
                        ->email()
                        ->required()
                        ->unique(table: User::class, column: 'email', ignorable: fn($record) => $record?->user),

                    TextInput::make('password')
                        ->label('Senha')
                        ->password()
                        ->placeholder('Digite uma senha segura')
                        ->required(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord)
                        ->minLength(8)
                        ->maxLength(255),
                ]),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('Nome'),
            TextColumn::make('user.email')->label('Email'),
            TextColumn::make('document')->label('CPF/CNPJ'),
            TextColumn::make('phone_number')->label('Telefone'),
        ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
