<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisitorLinksHeaderResource\{Pages};
use App\Models\VisitorLinksHeader;
use Filament\Forms\Components\{Select, TextInput, Toggle, View};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Table;
use Filament\{Tables};

class VisitorLinksHeaderResource extends Resource
{
    protected static ?string $model = VisitorLinksHeader::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $label = 'links de Visitantes Fixo';

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
                    ->icon(fn (VisitorLinksHeader $record): string => "heroicon-o-{$record->icon}")
                    ->color('primary'),
                IconColumn::make('is_active')
                    ->label('Ativo')
                    ->sortable()
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
            'index' => Pages\ManageVisitorLinksHeaders::route('/'),
        ];
    }
}
