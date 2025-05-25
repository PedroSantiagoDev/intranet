<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    protected $fillable = ['unit_id', 'user_id', 'title', 'file', 'is_active'];

    protected static function booted()
    {
        static::deleting(function ($news) {
            if ($news->file && Storage::disk('public')->exists($news->file)) {
                Storage::disk('public')->delete($news->file);
            }
        });
    }

    /**
     * @return BelongsTo<User,$this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<Unit,$this>
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
