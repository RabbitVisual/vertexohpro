<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CycleRecovery extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['student_id', 'school_class_id', 'cycle', 'score'];
=======
    protected $fillable = ['student_id', 'class_id', 'cycle', 'score'];
>>>>>>> origin/classrecord-module-setup-347080406940848607

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
<<<<<<< HEAD
        return $this->belongsTo(SchoolClass::class);
=======
        return $this->belongsTo(SchoolClass::class, 'class_id');
>>>>>>> origin/classrecord-module-setup-347080406940848607
    }
}
