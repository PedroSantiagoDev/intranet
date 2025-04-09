<?php

namespace App\Filament\Pages;

use App\Filament\Resources\LinkResource;
use App\Models\Link;
use Filament\Actions\Action;
use Filament\Pages\Page;

class LinkPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.link-page';

    protected function getHeaderActions(): array
    {
        return [
            Action::make('gerenciar')
                ->label('Gerenciar Links')
                ->url(LinkResource::getUrl())
                ->icon('heroicon-o-pencil-square')
                ->color('primary'),
        ];
    }

    public function getViewData(): array
    {
        return [
            'links'       => Link::where('is_active', true)->get(),
            'totalLinks'  => Link::count(),
            'activeLinks' => Link::where('is_active', true)->count(),
        ];
    }
}
