<?php

namespace Modules\Planning\Services;

use Modules\Planning\Models\LessonPlan;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\ClassDiary;
use Illuminate\Support\Facades\DB;

class LessonPlanService
{
    public function launchClass(LessonPlan $plan, $date = null)
    {
        if (!$plan->school_class_id) {
            throw new \Exception("Este plano não está vinculado a uma turma.");
        }

        return DB::transaction(function () use ($plan, $date) {
            return ClassDiary::create([
                'school_class_id' => $plan->school_class_id,
                'lesson_plan_id' => $plan->id,
                'user_id' => $plan->user_id,
                'date' => $date ?? now(),
                'content' => $plan->content, // Assuming content structure matches or needs adaptation
                'bncc_skills' => $plan->bncc_skills,
            ]);
        });
    }
}
