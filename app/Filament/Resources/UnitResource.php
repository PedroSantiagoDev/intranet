<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitResource\{Pages};
use App\Models\Unit;
use Filament\Forms\Components\{Section, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\{Tables};

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?string $label = "Unidade";

    protected static ?string $navigationGroup = 'Configurações';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações Básicas')
                    ->schema([
                        TextInput::make('name')
                           ->label('Nome')
                           ->required()
                           ->maxLength(255),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label('Telefone')
                            ->mask('(99) 9999-9999')
                            ->dehydrateStateUsing(fn ($state) => preg_replace('/[^0-9]/', '', $state))
                            ->maxLength(19),
                    ])->columns(3),
                Section::make('Endereço')
                    ->schema([
                        TextInput::make('postal_code')
                            ->label('CEP')
                            ->mask('99999-999')
                            ->dehydrateStateUsing(fn ($state) => preg_replace('/[^0-9]/', '', $state))
                            ->required()
                            ->maxLength(9),
                        TextInput::make('street')
                            ->label('Rua')
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
                        TextInput::make('state')
                            ->label('Estado')
                            ->required()
                            ->maxLength(2),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                   ->label('Nome')
                   ->searchable()
                   ->sortable(),
                TextColumn::make('city')
                    ->label('Cidade')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('state')
                    ->label('UF')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('phone')
                    ->label('Telefone')
                    ->formatStateUsing(fn ($state) => $state ? preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $state) : '')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
