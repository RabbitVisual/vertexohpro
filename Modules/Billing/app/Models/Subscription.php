<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;

class Subscription extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['user_id', 'plan_id', 'status', 'current_period_end'];

    protected $casts = [
        'current_period_end' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
