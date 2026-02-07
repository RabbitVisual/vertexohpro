<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_id',
        'cycle',
        'evaluation_number',
        'type',
        'score',
        'value',
        'locked_at'
    ];

    protected $casts = [
        'locked_at' => 'datetime',
        'score' => 'decimal:2',
        'value' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
}
