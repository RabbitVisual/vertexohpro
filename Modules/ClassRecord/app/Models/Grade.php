<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['school_class_id', 'student_id', 'activity_type', 'value', 'cycle', 'locked_at'];

    protected $casts = [
        'value' => 'decimal:2',
        'locked_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
