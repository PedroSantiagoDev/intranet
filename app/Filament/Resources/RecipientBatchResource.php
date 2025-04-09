<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RecipientBatchResource\Pages;
use App\Models\{Batch, Recipient};
use App\Services\XmlService;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\{Builder, Collection};
use Illuminate\Support\Facades\DB;

class RecipientBatchResource extends Resource
{
    protected static ?string $model = Recipient::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope-open';

    protected static ?string $navigationLabel = 'Gestão dos destinatários';

    protected static ?string $label = 'Gestão dos destinatários';

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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('create_batch')
                    ->label('Criar lote')
                    ->action(function (Collection $records) {
                        // TODO colocar em um enum os tamanhos fixos de arquivo
                        define('MAX_SIZE', 209715200); // 200mb

                        $totalSize = $records->sum('file_size');
                        $user      = user();

                        if (!$user->unit) {
                            Notification::make()
                                ->title('Vincular a uma unidade!')
                                ->body('Usuário esta sem veiculação com uma unidade')
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }

                        if ($totalSize > MAX_SIZE) {
                            Notification::make()
                                ->title('Tamanho excedido!')
                                ->body('O lote não pode ultrapassar 200MB')
                                ->danger()
                                ->persistent()
                                ->send();

                            return;
                        }

                        try {
                            DB::transaction(function () use ($records, $user) {
                                $batchNumber = Batch::generateBatchNumber();

                                $xml = (new XmlService(user: $user, batchNumber: $batchNumber))->create($records);

                                $batch = Batch::create([
                                    'number'     => $batchNumber,
                                    'xml_path'   => $xml,
                                    'user_id'    => user()->id,
                                    'batch_date' => now(),
                                ]);

                                $batch->recipients()->sync($records->modelKeys());

                                $records->first()->getModel()->whereIn('id', $records->modelKeys())->update(['in_batch' => true]);
                            });

                            Notification::make()
                                ->title('Lote criado com sucesso!')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Falha na operação')
                                ->body($e->getMessage())
                                ->danger()
                                ->persistent()
                                ->send();
                        }
                    })
                    ->requiresConfirmation()
                    ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListRecipientBatches::route('/'),
            // 'create' => Pages\CreateRecipientBatch::route('/create'),
            // 'edit'   => Pages\EditRecipientBatch::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
}
