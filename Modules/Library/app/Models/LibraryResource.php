<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;
use Illuminate\Database\Eloquent\Builder;

class LibraryResource extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'tags',
        'price',
        'status',
        'rejection_reason',
        'version',
        'free_until'
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
        'free_until' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function versions()
    {
        return $this->hasMany(ResourceVersion::class);
    }

    public function purchases()
    {
        return $this->hasMany(\Modules\Billing\Models\MaterialPurchase::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    public function isFree(): bool
    {
        return $this->price == 0 || ($this->free_until && $this->free_until->isFuture());
    }
}
