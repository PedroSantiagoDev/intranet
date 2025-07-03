<?php

namespace App\Services;

use App\Models\{NewsAlert, UnitLink, UserLink};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{Auth, Cache};

class DashboardService
{
    public function __construct(
        private NewsService $newsService
    ) {
    }

    public function getDashboardData(int $userId, int $unitId): array
    {
        return [
            'unitLinks' => $this->getActiveUnitLinks(),
            'userLinks' => $this->getActiveUserLinks($userId),
            'news'      => $this->newsService->getActiveNewsByUnit($unitId),
            'newsAlert' => $this->getActiveNewsAlert($unitId),
        ];
    }

    private function getActiveUnitLinks(): Collection
    {
        return Cache::remember('unit_links_links', 300, function () {
            return UnitLink::where('is_active', true)->where('unit_id', Auth::user()->unit_id)->orderBy('sort')->get();
        });
    }

    private function getActiveUserLinks(int $userId): Collection
    {
        return UserLink::where('user_id', $userId)
            ->where('is_active', true)
            ->orderBy('sort')
            ->get();
    }

    private function getActiveNewsAlert(int $unitId): ?NewsAlert
    {
        return NewsAlert::where('is_active', true)
            ->where(function ($query) use ($unitId) {
                $query->where('everyone', true)
                    ->orWhere('unit_id', $unitId);
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
