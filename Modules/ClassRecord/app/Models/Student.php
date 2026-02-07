<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = ['school_class_id', 'name', 'number'];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
