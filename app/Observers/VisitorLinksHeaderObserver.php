<?php

namespace App\Observers;

use App\Helpers\CacheHelper;
use App\Models\VisitorLinksHeader;
use Illuminate\Support\Facades\Log;

class VisitorLinksHeaderObserver
{
    /**
     * Handle the VisitorLinksHeader "created" event.
     */
    public function created(VisitorLinksHeader $visitorLinksHeader): void
    {
        $this->clearCache('created', $visitorLinksHeader->id);
    }

    /**
     * Handle the VisitorLinksHeader "updated" event.
     */
    public function updated(VisitorLinksHeader $visitorLinksHeader): void
    {
        // Se mudou o status ativo, limpar cache
        if ($visitorLinksHeader->wasChanged('is_active')) {
            $this->clearCache('updated', $visitorLinksHeader->id);
        }
    }

    /**
     * Handle the VisitorLinksHeader "deleted" event.
     */
    public function deleted(VisitorLinksHeader $visitorLinksHeader): void
    {
        $this->clearCache('deleted', $visitorLinksHeader->id);
    }

    /**
     * Handle the VisitorLinksHeader "restored" event.
     */
    public function restored(VisitorLinksHeader $visitorLinksHeader): void
    {
        $this->clearCache('restored', $visitorLinksHeader->id);
    }

    /**
     * Handle the VisitorLinksHeader "force deleted" event.
     */
    public function forceDeleted(VisitorLinksHeader $visitorLinksHeader): void
    {
        $this->clearCache('force_deleted', $visitorLinksHeader->id);
    }

    /**
     * Clear related caches when visitor links change
     */
    private function clearCache(string $action, int $id): void
    {
        try {
            // Limpar cache dos visitor links
            CacheHelper::clearVisitorLinks();

            Log::info("Cache cleared for VisitorLinksHeader - Action: {$action}, ID: {$id}");
        } catch (\Exception $e) {
            Log::error("Failed to clear cache for VisitorLinksHeader - Action: {$action}, ID: {$id}, Error: {$e->getMessage()}");
        }
    }
}
