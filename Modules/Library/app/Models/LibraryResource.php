<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Modules\Billing\Models\MaterialPurchase;

class LibraryResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'preview_image_path',
        'price',
        'subject',
        'tags'
    ];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function purchases()
    {
        return $this->hasMany(MaterialPurchase::class);
    }
}
