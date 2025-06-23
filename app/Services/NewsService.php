<?php

namespace App\Services;

use App\Models\{News};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    public function getActiveNewsByUnit(int $unitId): Collection
    {
        return News::with(['user:id,name', 'unit:id,name'])
            ->where('unit_id', $unitId)
            ->where('is_active', true)
            ->orderBy('sort')
            ->get()
            ->map(function ($news) {
                $news->file_url = $news->file ? Storage::url($news->file) : null;

                $news->url = $this->getNewsLinkUrl($news);

                $news->has_link = !empty($news->url);

                return $news;
            });
    }

    private function getNewsLinkUrl(News $news): ?string
    {
        switch ($news->link_type) {
            case 'url':
                return !empty($news->link_url) ? $news->link_url : null;

            case 'file':
                return !empty($news->link_file) ? Storage::url($news->link_file) : null;

            case 'none':
            default:
                return null;
        }
    }
}
