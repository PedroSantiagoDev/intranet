<?php

namespace App\Livewire;

use App\Models\{NewsAlert, VisitorLinksHeader};
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

    public function mount(): void
    {
        $this->visitorLinksHeader = VisitorLinksHeader::where('is_active', true)->orderBy('sort')->get();

        $this->newsAlert = NewsAlert::query()
            ->where('is_active', true)
            ->where('everyone', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
