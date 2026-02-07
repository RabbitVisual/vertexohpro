<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
<<<<<<< HEAD
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
=======
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan', 'amount', 'status', 'starts_at', 'ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
>>>>>>> origin/classrecord-module-setup-347080406940848607
    }
}
