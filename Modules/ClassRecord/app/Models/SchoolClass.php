<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Planning\Models\LessonPlan;
use Modules\ClassRecord\Models\ClassDiary;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = ['name', 'subject', 'year', 'user_id'];

    public function students()
    {
        return $this->hasMany(Student::class, 'class_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_id');
    }

    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function classDiaries()
    {
        return $this->hasMany(ClassDiary::class); // Assuming ClassDiary uses default conventions or we need to check FK
    }
}
