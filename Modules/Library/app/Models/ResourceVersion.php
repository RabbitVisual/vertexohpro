<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ResourceVersion extends Model
{
    use HasFactory;

    protected $fillable = [
        'library_resource_id',
        'version',
        'file_path',
        'changelog'
    ];

    public function resource()
    {
        return $this->belongsTo(LibraryResource::class, 'library_resource_id');
    }
}
