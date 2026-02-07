<?php

namespace Modules\Planning\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Core\Traits\Auditable;
use Modules\Planning\Database\Factories\LessonPlanFactory;

class LessonPlan extends Model
{
    use HasFactory, Auditable;

    protected $fillable = [
        'user_id',
        'title',
        'template_type',
        'content',
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
}
