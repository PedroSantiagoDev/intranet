<?php

namespace App\Livewire;

use App\Models\{NewsAlert, VisitorLinksHeader};
use App\Services\HomeService;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('CODEVASF')]
class Home extends Component
{
    /** @var Collection<int, VisitorLinksHeader> */
    public Collection $visitorLinksHeader;

    public ?NewsAlert $newsAlert = null;

    public function mount(HomeService $homeService): void
    {
        $data = $homeService->getHomeData();

        $this->visitorLinksHeader = $data['visitorLinksHeader'];
        $this->newsAlert          = $data['newsAlert'];
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
