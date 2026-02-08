<?php
# c:\xampp\htdocs\VertexOhPro\Modules\Library\app\Models\Material.php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'file_path',
        'preview_image_path',
        'tags',
        'bncc_codes',
        'downloads_count'
    ];

    protected $casts = [
        'tags' => 'array',
        'bncc_codes' => 'array',
        'downloads_count' => 'integer'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(MaterialRating::class);
    }

    public function purchasers()
    {
        return $this->belongsToMany(User::class, 'material_purchases', 'library_resource_id', 'user_id')
                    ->withPivot('status', 'amount', 'transaction_id')
                    ->withTimestamps();
    }
}
