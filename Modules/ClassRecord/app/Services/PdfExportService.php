<?php

namespace Modules\ClassRecord\Services;

use Modules\ClassRecord\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PdfExportService
{
    /**
     * Generate a digital report card PDF with a unique audit hash.
     *
     * @param Student $student
     * @return \Barryvdh\DomPDF\PDF
     */
    public function generateReportCard(Student $student)
    {
        // Gather data
        $student->load(['grades', 'attendances', 'schoolClass']);

        $grades = $student->grades;
        $attendanceStats = [
            'total' => $student->attendances->count(),
            'present' => $student->attendances->where('status', 'present')->count(),
            'absent' => $student->attendances->where('status', 'absent')->count(),
        ];

        // Generate a deterministic hash for audit
        // Hash components: StudentID + ClassID + CurrentDate + SerializedGrades (id, subject, score)
        $serializedGrades = $grades->map(fn($g) => $g->only(['id', 'subject', 'score']))->toJson();
        $dataToHash = "Student:{$student->id}|Class:{$student->school_class_id}|Date:" . now()->format('Y-m-d') . "|" . $serializedGrades;
        $signatureHash = hash('sha256', $dataToHash);

        // Create a unique ID for this report generation instance
        $reportId = Str::uuid();

        $data = [
            'student' => $student,
            'grades' => $grades,
            'attendance' => $attendanceStats,
            'school_class' => $student->schoolClass,
            'signature_hash' => $signatureHash,
            'report_id' => $reportId,
            'generated_at' => now(),
        ];

        // Load View and Return PDF object
        $pdf = Pdf::loadView('classrecord::pdf.report-card', $data);

        // Optional: Set paper size
        $pdf->setPaper('A4', 'portrait');

        return $pdf;
    }
}
