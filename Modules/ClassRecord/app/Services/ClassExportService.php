<?php

namespace Modules\ClassRecord\Services;

use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;

class ClassExportService
{
    public function export(int $classId)
    {
        $class = SchoolClass::with('students.grades', 'students.attendances')->findOrFail($classId);

        $csv = [];
        $headers = ['Nome do Aluno', 'Total Frequências', 'Média de Notas'];

        // Add dynamic headers for grades (e.g., Cycle 1, Cycle 2) if needed
        // For simplicity, just aggregate

        $csv[] = $headers;

        foreach ($class->students as $student) {
            $row = [
                $student->name,
                $student->attendances->where('present', true)->count() . '/' . $student->attendances->count(),
                number_format($student->grades->avg('value') ?? 0, 2),
            ];
            $csv[] = $row;
        }

        return $this->arrayToCsv($csv);
    }

    private function arrayToCsv(array $data)
    {
        $handle = fopen('php://temp', 'r+');
        foreach ($data as $line) {
            fputcsv($handle, $line);
        }
        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);
        return $content;
    }
}
