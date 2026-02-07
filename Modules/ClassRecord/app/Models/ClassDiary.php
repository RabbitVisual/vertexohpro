<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Planning\Models\LessonPlan;

class ClassDiary extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_class_id',
        'lesson_plan_id',
        'date',
        'content',
        'bncc_skills',
        'user_id'
    ];

    protected $casts = [
        'content' => 'array',
        'bncc_skills' => 'array',
        'date' => 'date',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function lessonPlan()
    {
        return $this->belongsTo(LessonPlan::class);
    }
}
