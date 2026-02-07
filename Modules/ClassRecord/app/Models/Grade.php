<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Grade extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['student_id', 'class_id', 'cycle', 'evaluation_number', 'score', 'locked_at'];

    protected $casts = [
        'score' => 'decimal:2',
        'locked_at' => 'datetime',
    ];
=======
    protected $fillable = ['student_id', 'subject', 'score', 'bncc_skill_code'];
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
<<<<<<< HEAD

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class, 'class_id');
    }
=======
>>>>>>> origin/feature/teacher-panel-widgets-12290637904403310292
}
