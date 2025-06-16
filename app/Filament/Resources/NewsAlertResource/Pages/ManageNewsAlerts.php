<?php

namespace App\Filament\Resources\NewsAlertResource\Pages;

use App\Filament\Resources\NewsAlertResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageNewsAlerts extends ManageRecords
{
    protected static string $resource = NewsAlertResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
