<?php

namespace App\Filament\Resources\RecipientBatchResource\Pages;

use App\Filament\Resources\RecipientBatchResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRecipientBatches extends ListRecords
{
    protected static string $resource = RecipientBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
