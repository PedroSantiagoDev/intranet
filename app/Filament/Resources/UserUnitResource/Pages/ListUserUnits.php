<?php

namespace App\Filament\Resources\UserUnitResource\Pages;

use App\Filament\Resources\UserUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserUnits extends ListRecords
{
    protected static string $resource = UserUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
