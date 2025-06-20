<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\{Builder, Model};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'date',
        'start_time',
        'end_time',
        'event_link',
        'subject',
        'observation',
        'status',
        'ti_equipment',
        'cancellation_reason',
    ];

    protected $casts = [
        'date'         => 'date',
        'start_time'   => 'datetime:H:i',
        'end_time'     => 'datetime:H:i',
        'ti_equipment' => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    // Scopes
    public function scopeByStatus(Builder $query, ReservationStatus $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByUser(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByUnit(Builder $query, int $unitId): Builder
    {
        return $query->where('unit_id', $unitId);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where('date', '>=', now()->toDateString());
    }

    public function scopeToday(Builder $query): Builder
    {
        return $query->where('date', now()->toDateString());
    }

    // Business logic methods
    public function canBeEdited(): bool
    {
        return $this->status === ReservationStatus::RESERVED->value;
    }

    public function isUpcoming(): bool
    {
        return $this->date >= now()->toDateString();
    }

    public function isPast(): bool
    {
        return $this->date < now()->toDateString();
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
