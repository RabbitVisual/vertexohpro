<?php

namespace Modules\ClassRecord\Services;

use Modules\ClassRecord\Models\Grade;
use Modules\ClassRecord\Models\CycleRecovery;

class GradeService
{
    /**
     * Calculate the average score for a student in a specific cycle.
     * Considers 'Parallel Recovery' if available.
     *
     * @param int $studentId
     * @param int $classId
     * @param int $cycle
     * @return float|null Returns average or null if no grades.
     */
<<<<<<< HEAD
    public function calculateCycleAverage(int $studentId, int $schoolClassId, int $cycle): ?float
    {
        $status = $this->getCycleStatus($studentId, $schoolClassId, $cycle);
=======
    public function calculateCycleAverage(int $studentId, int $classId, int $cycle): ?float
    {
        $status = $this->getCycleStatus($studentId, $classId, $cycle);
>>>>>>> origin/classrecord-module-setup-347080406940848607
        return $status['final'];
    }

    /**
     * Get detailed status of a student's cycle performance.
     *
     * @param int $studentId
     * @param int $classId
     * @param int $cycle
     * @return array
     */
<<<<<<< HEAD
    public function getCycleStatus(int $studentId, int $schoolClassId, int $cycle): array
    {
        $grades = Grade::where('student_id', $studentId)
            ->where('school_class_id', $schoolClassId)
=======
    public function getCycleStatus(int $studentId, int $classId, int $cycle): array
    {
        $grades = Grade::where('student_id', $studentId)
            ->where('class_id', $classId)
>>>>>>> origin/classrecord-module-setup-347080406940848607
            ->where('cycle', $cycle)
            ->get();

        if ($grades->isEmpty()) {
            return [
                'average' => null,
                'recovery' => null,
                'final' => null,
                'needs_recovery' => false,
            ];
        }

        $average = round($grades->avg('score'), 2);

        $recovery = CycleRecovery::where('student_id', $studentId)
<<<<<<< HEAD
            ->where('school_class_id', $schoolClassId)
=======
            ->where('class_id', $classId)
>>>>>>> origin/classrecord-module-setup-347080406940848607
            ->where('cycle', $cycle)
            ->first();

        $recoveryScore = $recovery ? $recovery->score : null;

        $final = $average;
        if ($recoveryScore !== null) {
            // Usually recovery replaces if higher, or some rules average it.
            // We'll assume it replaces if higher.
            $final = max($average, $recoveryScore);
        }

        return [
            'average' => $average,
            'recovery' => $recoveryScore,
            'final' => $final,
            'needs_recovery' => $average < 5.0,
        ];
    }
}
