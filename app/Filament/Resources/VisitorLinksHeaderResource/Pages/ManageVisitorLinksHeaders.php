<?php

namespace App\Filament\Resources\VisitorLinksHeaderResource\Pages;

use App\Filament\Resources\VisitorLinksHeaderResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitorLinksHeaders extends ManageRecords
{
    protected static string $resource = VisitorLinksHeaderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
