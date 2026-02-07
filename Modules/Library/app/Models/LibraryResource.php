<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LibraryResource extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'file_path', 'tags', 'price'];

    protected $casts = [
        'tags' => 'array',
        'price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
