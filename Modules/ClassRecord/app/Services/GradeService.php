<?php

namespace Modules\ClassRecord\Services;

use Modules\ClassRecord\Models\Grade;

class GradeService
{
    /**
     * Calculate the average score for a student in a specific cycle.
     *
     * @param int $studentId
     * @param int $classId
     * @param int $cycle
     * @return float|null Returns average or null if no grades.
     */
    public function calculateCycleAverage(int $studentId, int $classId, int $cycle): ?float
    {
        $grades = Grade::where('student_id', $studentId)
            ->where('class_id', $classId)
            ->where('cycle', $cycle)
            ->get();

        if ($grades->isEmpty()) {
            return null;
        }

        return round($grades->avg('score'), 2);
    }
}
