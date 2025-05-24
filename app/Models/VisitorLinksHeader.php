<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorLinksHeader extends Model
{
    protected $fillable = ['name', 'url', 'icon', 'is_active'];
}
