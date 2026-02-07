<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;
use Modules\Planning\Models\LessonPlan;

class SchoolClass extends Model
{
    use HasFactory, Auditable;

    protected $table = 'classes';
    protected $fillable = ['user_id', 'name', 'year', 'subject', 'is_multigrade', 'grades_covered'];

    protected $casts = [
        'is_multigrade' => 'boolean',
        'grades_covered' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_id');
    }
}
