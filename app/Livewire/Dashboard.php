<?php

namespace App\Livewire;

use App\Models\{News, UnitLink, UserLink};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Dashboard')]
class Dashboard extends Component
{
    /** @var Collection<int, UnitLink> */
    public Collection $unitLinks;

    /** @var Collection<int, UserLink> */
    public Collection $userLinks;

    /** @var Collection<int, News> */
    public Collection $news;

    public function mount(): void
    {
        $this->unitLinks = UnitLink::where('unit_id', auth()->user()->unit_id)
        ->where('is_active', true)
        ->get();

        $this->userLinks = auth()->user()->userLinks()
            ->where('is_active', true)
            ->get();

        $this->news = News::where('unit_id', auth()->user()->unit_id)
            ->where('is_active', true)
            ->get()
            ->map(function ($item) {
                $item->file = $item->file ? Storage::url($item->file) : null;

                return $item;
            });
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
