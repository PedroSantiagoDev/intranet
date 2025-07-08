<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\{Pages};
use App\Models\News;
use Filament\Forms\Components\{FileUpload, Hidden, Radio, Section, TextInput, Toggle};
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\{IconColumn, TextColumn};
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Support\Facades\Auth;

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
                        Hidden::make('unit_id')
                           ->default(Auth::user()->unit_id),
                        Hidden::make('user_id')
                            ->default(Auth::id()),
                    ]),

                Section::make('Link da Notícia')
                ->description('Configure um link para quando o usuário clicar na notícia')
                ->schema([
                    Radio::make('link_type')
                        ->label('Tipo de Link')
                        ->options([
                            'none' => 'Nenhum link',
                            'url'  => 'Link externo (URL)',
                            'file' => 'Arquivo (PDF)',
                        ])
                        ->default('none')
                        ->inline()
                        ->live(),
                    TextInput::make('link_url')
                        ->label('URL do Link')
                        ->url()
                        ->placeholder('https://exemplo.com')
                        ->visible(fn ($get) => $get('link_type') === 'url')
                        ->required(fn ($get) => $get('link_type') === 'url')
                        ->helperText('Digite a URL completa (incluindo https://)'),
                    FileUpload::make('link_file')
                        ->label('Arquivo')
                        ->directory('news-links')
                        ->maxSize(10240) // 10MB
                        ->acceptedFileTypes([
                            'application/pdf',
                        ])
                        ->visible(fn ($get) => $get('link_type') === 'file')
                        ->required(fn ($get) => $get('link_type') === 'file')
                        ->helperText('Formato aceito: PDF')
                        ->downloadable()
                        ->previewable(),
                ])
                ->collapsible()
                ->collapsed(fn ($record) => $record?->link_type === 'none'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(News::where('unit_id', Auth::user()->unit_id))
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('title')
                    ->label('Título')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                IconColumn::make('is_active')
                    ->label('Ativa?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Criada em')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Autor')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('unit.name')
                    ->label('Unidade'),
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
