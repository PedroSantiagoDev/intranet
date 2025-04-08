<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BatchResource\{Pages};
use App\Models\Batch;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\{Tables};
use ZipArchive;

class BatchResource extends Resource
{
    protected static ?string $model = Batch::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-arrow-down';

    protected static ?string $navigationGroup = 'Publisher';

    protected static ?int $navigationSort = 2;

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
            ->columns([
                TextColumn::make('number')
                    ->label('Número do Lote'),
                TextColumn::make('user.name')
                    ->label('Criado por'),
                TextColumn::make('recipients_count')
                    ->counts('recipients')
                    ->label('Destinatários'),
                TextColumn::make('batch_date')
                    ->label('Data do lote')
                    ->dateTime('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
                Action::make('download_zip')
                    ->label('Download Zip')
                    ->icon('heroicon-o-arrow-down-on-square-stack')
                    ->action(function (Batch $record) {
                        $user        = user();
                        $zipFilename = storage_path("app/public/recipient-pdf/e-Carta_{$user->unit->matrix_code}_{$record->number}_servico.zip");
                        $zip         = new ZipArchive();

                        try {
                            if ($zip->open($zipFilename, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                                throw new \Exception('Falha ao criar arquivo ZIP.');
                            }

                            $xmlPath = storage_path('app/public/' . $record->xml_path);

                            if (!file_exists($xmlPath)) {
                                throw new \Exception('Arquivo XML não encontrado');
                            }

                            $zip->addFile($xmlPath, basename($xmlPath));

                            foreach ($record->recipients as $recipient) {
                                if ($recipient->file_path) {
                                    $filePath = storage_path('app/public/recipient-pdf/' . $recipient->file_path);

                                    if (file_exists($filePath)) {
                                        $zip->addFile($filePath, basename($filePath));
                                    }
                                }
                            }

                            if ($zip->numFiles === 0) {
                                throw new \Exception('Nenhum arquivo válido para compactar');
                            }

                            $zip->close();

                            Notification::make()
                                ->title('Download iniciado com sucesso')
                                ->success()
                                ->send();

                            return response()->download($zipFilename)
                                ->deleteFileAfterSend(true);
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Erro: ' . $e->getMessage())
                                ->danger()
                                ->send();

                            if ($zip->status !== 0) {
                                $zip->close();
                            }

                            if (file_exists($zipFilename)) {
                                unlink($zipFilename);
                            }
                        }
                    }),
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
            'index' => Pages\ManageBatches::route('/'),
        ];
    }
}
