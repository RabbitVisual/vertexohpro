<?php

namespace Modules\ClassRecord\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Planning\Models\LessonPlan;

class SchoolClass extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'name', 'subject'];

    public function lessonPlans()
    {
        return $this->hasMany(LessonPlan::class);
    }

    public function classDiaries()
    {
        return $this->hasMany(ClassDiary::class);
    }
}
