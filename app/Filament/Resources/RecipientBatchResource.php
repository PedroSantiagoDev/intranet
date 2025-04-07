<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipientBatchResource\{Pages};
use App\Models\{Recipient};
use App\Services\XmlService;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\{Tables};
use Illuminate\Database\Eloquent\{Builder};

class RecipientBatchResource extends Resource
{
    protected static ?string $model = Recipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationLabel = 'Gestão dos destinatários';

    protected static ?string $navigationGroup = 'Publisher';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('in_batch', false))
            ->columns([
                TextColumn::make('user.name')
                    ->label('Criador'),
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
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('create_batch')
                    ->action(function ($records) {
                        // TODO colocar em um enum os tamanhos fixos de arquivo
                        define('MAX_SIZE', 209715200); // 200mb

                        $totalSize = $records->sum('file_size');

                        if ($totalSize > MAX_SIZE) {
                            Notification::make()
                                ->title('Tamanho excedido!')
                                ->body('O lote não pode ultrapassar 200MB')
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }

                        $xml = (new XmlService(user: user(), batchNumber: 16))->create($records);
                    }),
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
            'index'  => Pages\ListRecipientBatches::route('/'),
            'create' => Pages\CreateRecipientBatch::route('/create'),
            'edit'   => Pages\EditRecipientBatch::route('/{record}/edit'),
        ];
    }
}
