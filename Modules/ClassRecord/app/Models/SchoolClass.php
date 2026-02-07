<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchoolClass extends Model
{
    use HasFactory;

    protected $table = 'school_classes';
    protected $fillable = ['name', 'grade', 'year'];
    protected $fillable = ['name', 'is_multigrade', 'grades_covered'];

    protected $casts = [
        'is_multigrade' => 'boolean',
        'grades_covered' => 'array',
    ];
use Modules\Core\Traits\Auditable;
use Modules\Planning\Models\LessonPlan;

class SchoolClass extends Model
{
    use HasFactory, Auditable;

    protected $fillable = ['user_id', 'name', 'year', 'subject'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function classDiaries()
    {
        return $this->hasMany(ClassDiary::class);
    }
}
