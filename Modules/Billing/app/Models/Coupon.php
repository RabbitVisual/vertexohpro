<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code',
        'discount_percent',
        'valid_until'
    ];

    protected $casts = [
        'valid_until' => 'datetime',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchases()
    {
        return $this->hasMany(MaterialPurchase::class);
    }

    public function isValid()
    {
        return !$this->valid_until || $this->valid_until->isFuture();
    }
}
