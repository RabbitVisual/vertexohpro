<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Services\GradeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    protected $gradeService;

    public function __construct(GradeService $gradeService)
    {
        $this->gradeService = $gradeService;
    }

    public function showSignaturePage($studentId)
    {
        $student = Student::findOrFail($studentId);
        // Authorization check
        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        return view('classrecord::reports.sign', compact('student'));
    }

    public function generate($studentId, Request $request)
    {
        $request->validate([
            'signature' => 'required|string', // Base64
        ]);

        $student = Student::with(['schoolClass', 'attendances'])->findOrFail($studentId);

        if ($student->schoolClass->user_id !== auth()->id()) {
            abort(403);
        }

        // Prepare Grade Data for 4 Cycles (standard BNCC year)
        $cycles = [1, 2, 3, 4];
        $gradesData = [];

        foreach ($cycles as $cycle) {
            $status = $this->gradeService->getCycleStatus($student->id, $student->school_class_id, $cycle);
            $gradesData[$cycle] = $status;
        }

        // Attendance Summary
        $totalClasses = $student->schoolClass->attendances()
            ->where('student_id', $student->id)
            ->count();

        $absences = $student->attendances()
            ->where('status', 'absent')
            ->count();

        $attendancePercentage = $totalClasses > 0
            ? round((($totalClasses - $absences) / $totalClasses) * 100, 1)
            : 100;

        $pdf = Pdf::loadView('classrecord::reports.student-report', [
            'student' => $student,
            'class' => $student->schoolClass,
            'gradesData' => $gradesData,
            'attendancePercentage' => $attendancePercentage,
            'signature' => $request->input('signature'),
            'generatedAt' => now()->format('d/m/Y H:i'),
        ]);

        return $pdf->stream("boletim_{$student->name}.pdf");
    }

    public function batchExport($classId)
    {
        $schoolClass = SchoolClass::with(['students.grades'])->findOrFail($classId);

        $zipFileName = 'boletins_' . Str::slug($schoolClass->name) . '_' . date('Ymd_His') . '.zip';
        // Create in a temp directory
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($schoolClass->students as $student) {
                $pdf = Pdf::loadView('classrecord::pdf.report-card', [
                    'student' => $student,
                    'schoolClass' => $schoolClass,
                    'date' => now()->format('d/m/Y'),
                ]);
                $filename = Str::slug($student->name) . '_' . $student->id . '_Boletim.pdf';
                $zip->addFromString($filename, $pdf->output());
            }
            $zip->close();
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
