<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Library\Models\LibraryResource;

class MaterialPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'library_resource_id',
        'amount',
        'transaction_id',
        'coupon_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function resource()
    {
        return $this->belongsTo(LibraryResource::class, 'library_resource_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
