<?php

namespace App\Models;

use App\Enums\ReservationStatus;
use Illuminate\Database\Eloquent\{Model};
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'unit_id',
        'room_id',
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

    public function canBeEdited(): bool
    {
        return $this->status === ReservationStatus::RESERVED->value;
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
     * @return BelongsTo<Room,$this>
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
