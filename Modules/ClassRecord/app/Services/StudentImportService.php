<?php

namespace Modules\ClassRecord\Services;

use Illuminate\Support\Facades\DB;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;

class StudentImportService
{
    public function import(string $filePath, int $schoolClassId)
    {
        if (!file_exists($filePath)) {
            throw new \Exception("Arquivo não encontrado.");
        }

        $handle = fopen($filePath, 'r');
        if (!$handle) {
            throw new \Exception("Erro ao abrir arquivo.");
        }

        $headers = fgetcsv($handle, 1000, ',');
        // Simple validation: check if 'Nome' or 'Name' is in header
        // Assuming first column is Name for simplicity or specific header

        DB::beginTransaction();
        try {
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                // Assume Column 0 is Name
                $name = $data[0] ?? null;

                if ($name && strlen(trim($name)) > 0) {
                    Student::create([
                        'school_class_id' => $schoolClassId,
                        'name' => trim($name),
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            fclose($handle);
        }

        return true;
    }
}
