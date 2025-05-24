<?php

namespace App\Filament\Resources\UnitLinkResource\Pages;

use App\Filament\Resources\UnitLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageUnitLinks extends ManageRecords
{
    protected static string $resource = UnitLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
