<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'tags',
        'bncc_codes',
        'file_path',
        'user_id',
    ];

    protected $casts = [
        'tags' => 'array',
        'bncc_codes' => 'array',
        'price' => 'decimal:2',
    ];

    protected $appends = ['average_rating'];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'material_purchases', 'material_id', 'user_id')
                    ->withPivot('price_paid', 'purchased_at', 'status')
                    ->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(MaterialRating::class);
    }

    public function getAverageRatingAttribute()
    {
        return $this->ratings()->avg('rating') ?? 0;
    }
}
