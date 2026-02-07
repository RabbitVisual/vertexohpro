<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'plan', 'amount', 'status', 'starts_at', 'ends_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
