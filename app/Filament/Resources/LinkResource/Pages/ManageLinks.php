<?php

namespace App\Filament\Resources\LinkResource\Pages;

use App\Filament\Pages\LinkPage;
use App\Filament\Resources\LinkResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLinks extends ManageRecords
{
    protected static string $resource = LinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Voltar')
                ->url(LinkPage::getUrl()) // Volta para a listagem
                ->color('gray')
                ->icon('heroicon-m-arrow-uturn-left'),
            Actions\CreateAction::make(),
        ];
    }
}
