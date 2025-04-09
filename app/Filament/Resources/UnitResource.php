<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\{Pages};
use App\Helpers\SearchCepHelper;
use App\Models\Unit;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\{Section, Select, TextInput};
use Filament\Forms\{Form, Set};
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\{Tables};

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $navigationGroup = 'Admin';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Identificação da Unidade')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome Oficial da Unidade')
                            ->required()
                            ->maxLength(250)
                            ->helperText('Nome completo da Superintendência Regional conforme registro oficial'),
                        TextInput::make('sender_name')
                            ->label('Nome do Remetente Postal')
                            ->required()
                            ->maxLength(250)
                            ->helperText('Nome que aparecerá como remetente nos objetos postais do e-Carta'),
                    ])
                    ->columns(2),
                Section::make('Dados de Endereçamento')
                    ->schema([
                        TextInput::make('postal_code')
                            ->label('CEP da Unidade')
                            ->mask('99999-999')
                            ->required()
                            ->stripCharacters('-')
                            ->maxLength(9)
                            ->suffixAction(
                                Action::make('searchCep')
                                    ->icon('heroicon-o-magnifying-glass')
                                    ->label('Buscar CEP')
                                    ->action(function (Set $set, ?string $state) {
                                        $data = SearchCepHelper::search($state);

                                        if ($data) {
                                            $set('street', $data['logradouro'] ?? '');
                                            $set('neighborhood', $data['bairro'] ?? '');
                                            $set('city', $data['localidade'] ?? '');
                                            $set('state', $data['uf'] ?? '');

                                            Notification::make()
                                                ->success()
                                                ->title('CEP encontrado.')
                                                ->send();
                                        } else {
                                            $set('street', '');
                                            $set('neighborhood', '');
                                            $set('city', '');
                                            $set('state', '');

                                            Notification::make()
                                                ->danger()
                                                ->title('CEP inválido.')
                                                ->send();
                                        }
                                    })
                            )->helperText('CEP da sede da unidade'),
                        TextInput::make('street')
                            ->label('Logradouro')
                            ->required()
                            ->maxLength(226),
                        TextInput::make('number')
                            ->label('Número')
                            ->maxLength(36),
                        TextInput::make('complement')
                            ->label('Complemento')
                            ->maxLength(36),
                        TextInput::make('neighborhood')
                            ->label('Bairro')
                            ->maxLength(72),
                        TextInput::make('city')
                            ->label('Cidade')
                            ->required()
                            ->maxLength(72),
                        Select::make('state')
                            ->label('UF')
                            ->required()
                            ->options([
                                'AC' => 'Acre',
                                'AL' => 'Alagoas',
                                'AP' => 'Amapá',
                                'AM' => 'Amazonas',
                                'BA' => 'Bahia',
                                'CE' => 'Ceará',
                                'DF' => 'Distrito Federal',
                                'ES' => 'Espírito Santo',
                                'GO' => 'Goiás',
                                'MA' => 'Maranhão',
                                'MT' => 'Mato Grosso',
                                'MS' => 'Mato Grosso do Sul',
                                'MG' => 'Minas Gerais',
                                'PA' => 'Pará',
                                'PB' => 'Paraíba',
                                'PR' => 'Paraná',
                                'PE' => 'Pernambuco',
                                'PI' => 'Piauí',
                                'RJ' => 'Rio de Janeiro',
                                'RN' => 'Rio Grande do Norte',
                                'RS' => 'Rio Grande do Sul',
                                'RO' => 'Rondônia',
                                'RR' => 'Roraima',
                                'SC' => 'Santa Catarina',
                                'SP' => 'São Paulo',
                                'SE' => 'Sergipe',
                                'TO' => 'Tocantins',
                            ])
                            ->searchable(),
                    ])->columns(2),

                Section::make('Telefone e E-mail')
                    ->schema([
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(98)9999-9999')
                            ->maxLength(11),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->maxLength(255),
                    ])->columns(2),

                Section::make('Configurações do e-Carta')
                    ->schema([
                        TextInput::make('matrix_code')
                            ->label('Código da Matriz (MM)')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Identificador único fornecido pelos Correios após homologação'),
                        TextInput::make('contract_number')
                            ->label('Número do Contrato')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Número do contrato com os Correios para serviço e-Carta'),
                        TextInput::make('postage_card')
                            ->label('Cartão de Postagem')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Código do cartão de postagem vinculado ao contrato'),
                    ])
                    ->columns(3),
                Section::make('Identificação Operacional')
                    ->schema([
                        TextInput::make('administrative_number')
                            ->label('Código Administrativo')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Código interno da unidade para controle operacional'),
                        TextInput::make('posting_unit')
                            ->label('Unidade de Postagem')
                            ->required()
                            ->maxLength(10)
                            ->helperText('Código da unidade dos Correios responsável pela operação'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nome'),
                TextColumn::make('postal_code')
                    ->label('CEP'),
                TextColumn::make('street')
                    ->label('Endereço'),
                TextColumn::make('city')
                    ->label('Cidade'),
                TextColumn::make('state')
                    ->label('Estado'),
                TextColumn::make('matrix_code')
                    ->label('Código da matrix'),
                TextColumn::make('contract_number')
                    ->label('Número do contrato'),
                TextColumn::make('postage_card')
                    ->label('Cartão de postagem'),
                TextColumn::make('administrative_number')
                    ->label('Número do administrativo'),
                TextColumn::make('posting_unit')
                    ->label('Número da unidade'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index'  => Pages\ListUnits::route('/'),
            'create' => Pages\CreateUnit::route('/create'),
            'edit'   => Pages\EditUnit::route('/{record}/edit'),
        ];
    }
}
