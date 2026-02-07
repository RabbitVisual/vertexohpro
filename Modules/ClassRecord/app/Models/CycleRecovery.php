<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CycleRecovery extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'school_class_id', 'cycle', 'score'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }
}
