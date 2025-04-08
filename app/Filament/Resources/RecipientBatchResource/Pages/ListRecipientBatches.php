<?php

namespace App\Filament\Resources\RecipientBatchResource\Pages;

use App\Filament\Resources\RecipientBatchResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRecipientBatches extends ListRecords
{
    protected static string $resource = RecipientBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'Auto envelopamento' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('finish_type', 'SELFENVELOPMENT'))
                ->icon('heroicon-o-envelope-open'),
            'Inserção' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('finish_type', 'INSERTION'))
                ->icon('heroicon-o-envelope'),
        ];
    }
}
