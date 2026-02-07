<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\ClassDiary;

class LessonPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_class_id',
        'title',
        'content',
        'template_type',
        'bncc_skills',
    ];

    protected $casts = [
        'content' => 'array',
        'bncc_skills' => 'array',
    ];

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function classDiaries()
    {
        return $this->hasMany(ClassDiary::class);
    }
}
