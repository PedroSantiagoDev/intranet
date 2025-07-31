<?php

namespace App\Filament\Resources\UserUnitResource\Pages;

use App\Filament\Resources\UserUnitResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUserUnit extends EditRecord
{
    protected static string $resource = UserUnitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
