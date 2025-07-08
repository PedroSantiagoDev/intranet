<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsAlertResource\{Pages};
use App\Models\NewsAlert;
use Filament\Forms\Components\{Hidden, Select, TextInput, Textarea, Toggle};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Support\Facades\Auth;

class NewsAlertResource extends Resource
{
    protected static ?string $model = NewsAlert::class;

    protected static ?string $navigationIcon = 'heroicon-o-bell';

    protected static ?string $label = 'Alertas';

    protected static ?string $navigationGroup = 'Notícias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->label('Título')
                    ->maxLength(255)
                    ->required()
                    ->placeholder('Digite o título do alerta'),
                Textarea::make('content')
                    ->label('Conteúdo')
                    ->required()
                    ->placeholder('Digite o conteúdo do alerta'),
                Select::make('type')
                    ->label('Tipo')
                    ->required()
                    ->options([
                        'alert' => 'Alerta',
                        'info'  => 'Informação',
                    ]),
                Toggle::make('is_active')
                    ->label('Ativo?')
                    ->inline()
                    ->default(true),
                Toggle::make('everyone')
                    ->label('Para todos?')
                    ->inline()
                    ->default(false)
                    ->visible(Auth::user()?->hasRole('super_admin'))
                    ->helperText('Se ativado, o alerta será visível para todos os usuários, independentemente da unidade.'),
                Hidden::make('unit_id')
                    ->default(Auth::user()->unit_id),
                Hidden::make('user_id')
                    ->default(Auth::id()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(NewsAlert::where('unit_id', Auth::user()->unit_id))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('content')
                    ->label('Conteúdo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable(),
                TextColumn::make('unit.name')
                    ->label('Unidade')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Ativa?')
                    ->boolean(),
                IconColumn::make('everyone')
                    ->label('Para todos?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
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
            'index' => Pages\ManageNewsAlerts::route('/'),
        ];
    }
}
