<?php

namespace App\Services;

use App\Models\{NewsAlert, VisitorLinksHeader};
use Illuminate\Database\Eloquent\Collection;

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
        return VisitorLinksHeader::where('is_active', true)->orderBy('sort')->get();
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
