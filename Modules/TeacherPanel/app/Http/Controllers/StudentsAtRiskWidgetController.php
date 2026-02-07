<?php

namespace Modules\TeacherPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentsAtRiskWidgetController extends Controller
{
    /**
     * Get students at risk (grade < 5.0 OR absence > 25%).
     */
    public function index()
    {
        // Fetch students with their average grade and attendance stats
        $students = Student::with(['grades', 'attendances', 'schoolClass'])
            ->get()
            ->map(function ($student) {
                // Calculate Average Grade
                $averageGrade = $student->grades->avg('score');

                // Calculate Absence Rate
                $totalClasses = $student->attendances->count();
                $absences = $student->attendances->where('status', 'absent')->count();
                $absenceRate = $totalClasses > 0 ? ($absences / $totalClasses) * 100 : 0;

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'class_name' => $student->schoolClass ? $student->schoolClass->name : 'N/A',
                    'average_grade' => $averageGrade !== null ? round($averageGrade, 2) : 0,
                    'absence_rate' => round($absenceRate, 1),
                    'is_risk_grade' => $averageGrade !== null && $averageGrade < 5.0,
                    'is_risk_attendance' => $absenceRate > 25,
                ];
            })
            ->filter(function ($student) {
                return $student['is_risk_grade'] || $student['is_risk_attendance'];
            })
            ->values();

        return response()->json($students);
    }
}
