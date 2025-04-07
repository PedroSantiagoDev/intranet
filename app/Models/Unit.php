<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    protected $table = 'units';

    protected $fillable = [
        'name',
        'sender_name',
        'sender_street',
        'sender_number',
        'sender_complement',
        'sender_neighborhood',
        'sender_city',
        'sender_state',
        'sender_postal_code',
        'matrix_code',
        'contract_number',
        'postage_card',
        'administrative_number',
        'posting_unit',
    ];

    /**
     * @return HasMany<User,$this>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
