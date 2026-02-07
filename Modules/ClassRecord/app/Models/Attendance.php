<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['student_id', 'class_id', 'date', 'status', 'observation'];

    protected $casts = [
        'date' => 'date',
    ];
=======
    protected $fillable = ['student_id', 'school_class_id', 'date', 'status'];
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function schoolClass()
    {
<<<<<<< HEAD
        return $this->belongsTo(SchoolClass::class, 'class_id');
=======
        return $this->belongsTo(SchoolClass::class);
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
    }
}
