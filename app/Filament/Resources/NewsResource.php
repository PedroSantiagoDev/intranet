<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\{Pages};
use App\Models\News;
use Filament\Forms\Components\{FileUpload, Hidden, Section, TextInput, Toggle};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\{Tables};

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $label = 'Notícias';

    protected static ?string $navigationGroup = 'Notícias';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informações da Notícia')
                    ->schema([
                        TextInput::make('title')
                            ->label('Título')
                            ->maxLength(255)
                            ->required(),
                        FileUpload::make('file')
                            ->label('Imagem')
                            ->directory('news-attachments')
                            ->maxSize(2048) // 2MB
                            ->image()
                            ->required(),
                        Toggle::make('is_active')
                            ->label('Ativo?')
                             ->inline()
                            ->default(true),
                        Hidden::make('user_id')
                            ->default(auth()->id()),
                        Hidden::make('unit_id')
                            ->default(auth()->user()->unit_id),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Ativa?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Autor')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Ativa')
                    ->trueLabel('Ativas')
                    ->falseLabel('Inativas')
                    ->placeholder('Todas'),
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
            'index'  => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit'   => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}
