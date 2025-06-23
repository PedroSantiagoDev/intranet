<?php

namespace App\Services;

use App\Models\{NewsAlert, VisitorLinksHeader};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class HomeService
{
    public function getHomeData(): array
    {
        return [
            'visitorLinksHeader' => $this->getActiveVisitorLinks(),
            'newsAlert'          => $this->getActiveNewsAlert(),
        ];
    }

    private function getActiveVisitorLinks(): Collection
    {
        return Cache::remember('visitor_links_active', 300, function () {
            return VisitorLinksHeader::where('is_active', true)->orderBy('sort')->get();
        });
    }

    private function getActiveNewsAlert(): ?NewsAlert
    {
        return NewsAlert::query()
            ->where('is_active', true)
            ->where('everyone', true)
            ->orderBy('created_at', 'desc')
            ->first();
    }
}
