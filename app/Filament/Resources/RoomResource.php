<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\{Pages};
use App\Models\Room;
use Filament\Forms\Components\{Hidden, TextInput, Toggle};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Support\Facades\Auth;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Salas das Unidades';

    protected static ?string $navigationGroup = 'Reservas';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole(['admin', 'super_admin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome da Sala')
                    ->maxLength(255)
                    ->autofocus()
                    ->required(),
                Toggle::make('is_active')
                    ->label('Ativo?')
                    ->inline()
                    ->default(true),
                Hidden::make('unit_id')
                    ->default(Auth::user()->unit_id),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Room::where('unit_id', Auth::user()->unit_id))
            ->columns([
                TextColumn::make('name')
                   ->label('Nome da Sala')
                   ->searchable()
                   ->sortable(),
                TextColumn::make('unit.name')
                   ->label('Unidade')
                   ->searchable()
                   ->sortable(),
                IconColumn::make('is_active')
                    ->label('Ativa?')
                    ->boolean(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageRooms::route('/'),
        ];
    }
}
