<?php

namespace Modules\ClassRecord\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\ClassRecord\Models\SchoolClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    public function batchExport($classId)
    {
        $schoolClass = SchoolClass::with(['students.grades'])->findOrFail($classId);

        $zipFileName = 'boletins_' . Str::slug($schoolClass->name) . '_' . date('Ymd_His') . '.zip';
        // Create in a temp directory
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($schoolClass->students as $student) {
                // Assuming grades are eager loaded
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
