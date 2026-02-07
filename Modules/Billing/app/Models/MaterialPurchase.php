<?php

namespace Modules\Billing\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaterialPurchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'library_resource_id',
        'amount',
        'transaction_id'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function resource()
    {
        return $this->belongsTo(\Modules\Library\Models\LibraryResource::class, 'library_resource_id');
    }
}
