<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

class Batch extends Model
{
    protected $table = 'batches';

    protected $fillable = [
        'number',
        'xml_path',
        'user_id',
        'batch_date',
    ];

    /**
     * @return BelongsTo<User,$this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<Recipient, $this, BatchRecipient>
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(Recipient::class)
            ->using(BatchRecipient::class)
            ->withTimestamps();
    }

    public static function generateBatchNumber(): int
    {
        return static::lockForUpdate()->max('number') + 1;
    }
}
