<?php

namespace App\Livewire;

use App\Models\{News, VisitorLinks, VisitorLinksHeader};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.guest')]
#[Title('CODEVASF')]
class Home extends Component
{
    /** @var Collection<int, VisitorLinksHeader> */
    public Collection $visitorLinksHeader;

    /** @var Collection<int, VisitorLinks> */
    public Collection $visitorLinks;

    /** @var Collection<int, News> */
    public Collection $news;

    public function mount(): void
    {
        $this->visitorLinksHeader = VisitorLinksHeader::where('is_active', true)->get();

        $this->visitorLinks = VisitorLinks::where('is_active', true)->get();

        $this->news = News::where('is_active', true)
            ->get()
            ->map(function ($item) {
                $item->file = $item->file ? Storage::url($item->file) : null;

                return $item;
            });
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
