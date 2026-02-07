<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CycleClosure extends Model
{
    use HasFactory;

    protected $fillable = ['school_class_id', 'cycle', 'signature', 'signed_at'];

    protected $casts = [
        'signed_at' => 'datetime',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
