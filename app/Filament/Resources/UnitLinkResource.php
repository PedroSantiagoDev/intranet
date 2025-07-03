<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UnitLinkResource\{Pages};
use App\Models\UnitLink;
use Filament\Forms\Components\{Hidden, Select, TextInput, Toggle, View};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UnitLinkResource extends Resource
{
    protected static ?string $model = UnitLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $label = 'links da unidade';

    protected static ?string $navigationGroup = 'Links';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nome')
                    ->autofocus()
                    ->maxLength(255)
                    ->required(),
                TextInput::make('url')
                    ->label('Url')
                    ->maxLength(255)
                    ->url()
                    ->required(),
                Select::make('icon')
                    ->label('Ícone')
                    ->required()
                    ->options(config('icons'))
                    ->searchable()
                    ->default('link')
                    ->live(),
                View::make('livewire.partials.icon-helper')
                    ->reactive()
                    ->visible(fn ($get) => filled($get('icon')))
                    ->viewData(fn ($get) => ['icon' => $get('icon')]),
                Toggle::make('is_active')
                    ->label('Ativo?')
                    ->inline()
                    ->default(true),
                Select::make('unit_id')
                    ->label('Unidade')
                    ->relationship('unit', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Hidden::make('user_id')
                    ->default(auth()->id()),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                   ->label('Nome')
                   ->searchable()
                   ->sortable(),
                TextColumn::make('url')
                    ->label('URL')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('icon')
                    ->label('Ícone')
                    ->icon(fn (UnitLink $record): string => "heroicon-o-{$record->icon}")
                    ->color('primary'),
                TextColumn::make('unit.name')
                   ->label('Unidade')
                   ->searchable()
                   ->sortable(),
                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->sortable()
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('unit')
                ->relationship('unit', 'name')
                ->default(Auth::user()->unit_id)
                ->label('Filtrar por Unidade')
                ->query(function (Builder $query, array $data) {
                    if (!empty($data['value'])) {
                        $query->where('unit_id', $data['value']);
                    }
                }),
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
            'index' => Pages\ManageUnitLinks::route('/'),
        ];
    }
}
