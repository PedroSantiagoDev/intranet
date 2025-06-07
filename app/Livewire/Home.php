<?php

namespace App\Livewire;

use App\Models\{VisitorLinksHeader};
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

    public function mount(): void
    {
        $this->visitorLinksHeader = VisitorLinksHeader::where('is_active', true)->get();
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
