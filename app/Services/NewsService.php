<?php

namespace App\Services;

use App\Models\{News, User};
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class NewsService
{
    public function getActiveNewsByUnit(int $unitId): Collection
    {
        return News::with(['user:id,name', 'unit:id,name'])
            ->where('unit_id', $unitId)
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($news) {
                $news->file_url = $news->file ? Storage::url($news->file) : null;

                return $news;
            });
    }

    public function createNews(array $data, User $user): News
    {
        $data['user_id'] = $user->id;
        $data['unit_id'] = $user->unit_id;

        return News::create($data);
    }

    public function updateNews(News $news, array $data): bool
    {
        // Handle file update if needed
        if (isset($data['file']) && $news->file && $news->file !== $data['file']) {
            $this->deleteNewsFile($news);
        }

        return $news->update($data);
    }

    public function deleteNews(News $news): bool
    {
        $this->deleteNewsFile($news);

        return $news->delete();
    }

    private function deleteNewsFile(News $news): void
    {
        if ($news->file && Storage::disk('public')->exists($news->file)) {
            Storage::disk('public')->delete($news->file);
        }
    }

    public function getNewsStats(int $unitId): array
    {
        $total    = News::where('unit_id', $unitId)->count();
        $active   = News::where('unit_id', $unitId)->where('is_active', true)->count();
        $inactive = $total - $active;

        return [
            'total'    => $total,
            'active'   => $active,
            'inactive' => $inactive,
        ];
    }
}
