<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LessonPlan extends Model
{
    use HasFactory;

    protected $table = 'lesson_plans';

    protected $fillable = [
        'title',
        'sections'
    ];

    protected $casts = [
        'sections' => 'array',
    ];
}
