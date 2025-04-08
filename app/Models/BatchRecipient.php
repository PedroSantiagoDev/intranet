<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BatchRecipient extends Pivot
{
    protected $table = 'batch_recipient';

    protected $fillable = [
        'recipient_id',
        'batch_id',
    ];
}
