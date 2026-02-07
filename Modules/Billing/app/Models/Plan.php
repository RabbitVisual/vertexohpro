<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'modules_access',
        'is_active',
    ];

    protected $casts = [
        'modules_access' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];
}
