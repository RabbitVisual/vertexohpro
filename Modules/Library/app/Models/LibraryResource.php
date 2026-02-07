<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;

class LibraryResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'tags',
        'price',
        'status',
        'rejection_reason'
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function scopeApproved(Builder $query): void
    {
        $query->where('status', 'approved');
    }

    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }
}
