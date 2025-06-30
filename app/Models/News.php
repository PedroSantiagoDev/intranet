<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Relations\{BelongsTo};
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    protected $fillable = ['unit_id', 'user_id', 'title', 'file',  'link_url', 'link_file', 'link_type', 'is_active'];

    protected $casts = [
        'is_active'  => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes for better query organization
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeByUnit(Builder $query, int $unitId): Builder
    {
        return $query->where('unit_id', $unitId);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Accessors
    public function getFileUrlAttribute(): ?string
    {
        return $this->file ? Storage::url($this->file) : null;
    }

    public function getLinkUrlAttribute($value)
    {
        if ($this->link_type === 'file' && $this->link_file) {
            return Storage::url($this->link_file);
        }

        return $value;
    }

    public function getHasLinkAttribute()
    {
        return $this->link_type !== 'none' &&
               (($this->link_type === 'url' && !empty($this->attributes['link_url'])) ||
                ($this->link_type === 'file' && !empty($this->link_file)));
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

    /**
     * O método boot é chamado automaticamente quando o modelo é iniciado.
     * É o lugar ideal para registrar listeners de eventos do modelo.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function (News $news) {
            self::deleteAssociatedFile($news->file);
            self::deleteAssociatedFile($news->link_file);
        });

        static::updating(function (News $news) {
            if ($news->isDirty('file') && $news->getOriginal('file')) {
                self::deleteAssociatedFile($news->getOriginal('file'));
                self::deleteAssociatedFile($news->getOriginal('link_file'));
            }
        });
    }

    /**
     * Helper method to delete a file from storage.
     *
     * @param string|null $filePath The path to the file to be deleted.
     */
    protected static function deleteAssociatedFile(?string $filePath): void
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
