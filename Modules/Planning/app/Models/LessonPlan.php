<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\ClassDiary;

class LessonPlan extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'school_class_id',
        'title',
        'content',
        'template_type',
        'bncc_codes',
    ];

    protected $casts = [
        'content' => 'array',
        'bncc_codes' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function schoolClass()
    {
        return $this->belongsTo(SchoolClass::class);
    }

    public function classDiaries()
    {
        return $this->hasMany(ClassDiary::class);
    }
}
