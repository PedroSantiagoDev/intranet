<?php

namespace App\Filament\Resources\VisitorLinksResource\Pages;

use App\Filament\Resources\VisitorLinksResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVisitorLinks extends ManageRecords
{
    protected static string $resource = VisitorLinksResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
