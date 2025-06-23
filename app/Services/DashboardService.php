<?php

namespace App\Services;

use App\Models\{NewsAlert, UserLink, VisitorLinksHeader};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    public function __construct(
        private NewsService $newsService
    ) {
    }

    public function getDashboardData(int $userId, int $unitId): array
    {
        return [
            'unitLinks' => $this->getActiveVisitorLinks(),
            'userLinks' => $this->getActiveUserLinks($userId),
            'news'      => $this->newsService->getActiveNewsByUnit($unitId),
            'newsAlert' => $this->getActiveNewsAlert($unitId),
        ];
    }

    private function getActiveVisitorLinks(): Collection
    {
        return Cache::remember('visitor_links_active', 300, function () {
            return VisitorLinksHeader::where('is_active', true)->orderBy('sort')->get();
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
        return Cache::remember("news_alert_unit_{$unitId}", 300, function () use ($unitId) {
            return NewsAlert::where('is_active', true)
                ->where(function ($query) use ($unitId) {
                    $query->where('everyone', true)
                        ->orWhere('unit_id', $unitId);
                })
                ->orderBy('created_at', 'desc')
                ->first();
        });
    }
}
