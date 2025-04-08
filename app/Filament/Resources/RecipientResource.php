<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipientResource\{Pages};
use App\Helpers\{PdfParserHelper, SearchCepHelper};
use App\Models\Recipient;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\{FileUpload, Hidden, Select, TextInput};
use Filament\Forms\{Form, Set};
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Database\Eloquent\{Builder};

class RecipientResource extends Resource
{
    protected static ?string $model = Recipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->required()
                    ->maxLength(250),
                TextInput::make('postal_code')
                    ->label('CEP')
                    ->mask('99999-999')
                    ->required()
                    ->maxLength(9)
                    ->live(onBlur: true)
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
                    ),
                TextInput::make('street')
                    ->label('Endereço')
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
                    ->label('Estado')
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
                FileUpload::make('file_path')
                    ->label('PDF')
                    ->required()
                    ->acceptedFileTypes(['application/pdf'])
                    ->directory('recipient-pdf')
                    ->maxSize(104857600) // 100mb
                    ->afterStateUpdated(function (Set $set, object $state) {
                        $data = PdfParserHelper::parser($state->path());

                        if ($data === null) {
                            Notification::make()
                                ->title('Falha ao ler PDF.')
                                ->danger()
                                ->send();

                            return;
                        }

                        $set('file_pages', $data['pages']);
                        $set('file_size', $data['size']);
                    }),
                Hidden::make('file_pages'),
                Hidden::make('file_size'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', user()->id))
            ->columns([
                TextColumn::make('name')
                    ->label('Nome')
                    ->searchable(),
                TextColumn::make('postal_code')
                    ->label('CEP'),
                TextColumn::make('street')
                    ->label('Endereço'),
                TextColumn::make('city')
                    ->label('Cidade'),
                TextColumn::make('state')
                    ->label('Estado'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                //
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
            'index'  => Pages\ListRecipients::route('/'),
            'create' => Pages\CreateRecipient::route('/create'),
            'edit'   => Pages\EditRecipient::route('/{record}/edit'),
        ];
    }
}
