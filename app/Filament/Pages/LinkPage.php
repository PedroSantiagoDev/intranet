<?php

namespace App\Filament\Pages;

use App\Models\Link;
use Filament\Pages\Page;

class LinkPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static string $view = 'filament.pages.link-page';

    protected static ?string $navigationLabel = 'Links';

    protected static ?string $title = 'Seus links';

    public function getViewData(): array
    {
        return [
            'links' => Link::where('is_active', true)->get(),
        ];
    }
}
