<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLink extends Model
{
    protected $fillable = ['user_id', 'name', 'url', 'icon', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * @return BelongsTo<User,$this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
