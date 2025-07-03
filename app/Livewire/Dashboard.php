<?php

namespace App\Livewire;

use App\Models\{News, NewsAlert, UnitLink, UserLink};
use App\Services\DashboardService;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Attributes\{Layout, Title};
use Livewire\Component;

#[Layout('components.layouts.app')]
#[Title('Início')]
class Dashboard extends Component
{
    /** @var Collection<int, UnitLink> */
    public Collection $unitLinks;

    /** @var Collection<int, UserLink> */
    public Collection $userLinks;

    /** @var Collection<int, News> */
    public Collection $news;

    public ?NewsAlert $newsAlert = null;

    public function mount(DashboardService $dashboardService): void
    {
        $user = auth()->user();

        $data = $dashboardService->getDashboardData($user->id, $user->unit_id);

        $this->unitLinks = $data['unitLinks'];
        $this->userLinks = $data['userLinks'];
        $this->news      = $data['news'];
        $this->newsAlert = $data['newsAlert'];
    }

    public function render(): View
    {
        return view('livewire.dashboard');
    }
}
