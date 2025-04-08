<?php

namespace App\Filament\Resources\RecipientBatchResource\Pages;

use App\Filament\Resources\RecipientBatchResource;
use App\Models\Recipient;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListRecipientBatches extends ListRecords
{
    protected static string $resource = RecipientBatchResource::class;

    public function getTabs(): array
    {
        $selfEnvelopmentCount = Recipient::query()
            ->where('finish_type', 'SELFENVELOPMENT')
            ->count();

        $insertionCount = Recipient::query()
            ->where('finish_type', 'INSERTION')
            ->count();

        return [
            'Auto envelopamento' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('finish_type', 'SELFENVELOPMENT'))
                ->icon('heroicon-o-envelope-open')
                ->badge($selfEnvelopmentCount),
            'Inserção' => Tab::make()
                ->modifyQueryUsing(fn (Builder $query) => $query->where('finish_type', 'INSERTION'))
                ->icon('heroicon-o-envelope')
                ->badge($insertionCount),
        ];
    }
}
