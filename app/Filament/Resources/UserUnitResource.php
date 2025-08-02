<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserUnitResource\{Pages};
use App\Models\User;
use Filament\Forms\Components\{Hidden, Section, Select, TextInput};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Support\Facades\{Auth, Hash};
use Spatie\Permission\Models\Role;

class UserUnitResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $label = 'Usuários';

    protected static ?string $navigationLabel = 'Usuários da Unidade';

    protected static ?string $navigationGroup = 'Configurações';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('admin') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações do Usuário')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('E-mail')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create')
                            ->maxLength(255)
                            ->confirmed(),
                        TextInput::make('password_confirmation')
                            ->label('Confirmar Senha')
                            ->password()
                            ->requiredWith('password')
                            ->maxLength(255),
                        Select::make('roles')
                            ->label('Funções')
                            ->relationship('roles', 'name')
                            ->options(Role::where('name', '!=', 'super_admin')->pluck('name', 'id')->all())
                            ->multiple()
                            ->preload()
                            ->searchable(),
                        Hidden::make('unit_id')
                            ->default(Auth::user()->unit_id),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(User::where('unit_id', Auth::user()->unit_id))
            ->columns([
                TextColumn::make('name')
                  ->label('Nome')
                  ->searchable()
                  ->sortable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable()
                   ->sortable(),
                TextColumn::make('unit.name')
                    ->label('Unidade')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Funções')
                    ->badge()
                    ->color('primary')
                    ->separator(','),
                TextColumn::make('created_at')
                    ->label('Criado em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('roles')
                   ->label('Filtrar por Função')
                   ->relationship('roles', 'name')
                   ->multiple()
                   ->preload(),
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
            'index'  => Pages\ListUserUnits::route('/'),
            'create' => Pages\CreateUserUnit::route('/create'),
            'edit'   => Pages\EditUserUnit::route('/{record}/edit'),
        ];
    }
}
