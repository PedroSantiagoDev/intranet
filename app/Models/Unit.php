<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'postal_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'phone',
        'email',
    ];

    /**
    * @return HasMany<User,$this>
    */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return HasMany<UnitLink,$this>
     */
    public function unitLinks(): HasMany
    {
        return $this->hasMany(UnitLink::class);
    }

    /**
     * @return HasMany<News,$this>
     */
    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
