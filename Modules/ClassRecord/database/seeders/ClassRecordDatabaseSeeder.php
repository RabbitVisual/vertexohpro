<?php

namespace Modules\ClassRecord\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ClassRecord\Models\SchoolClass;
use Modules\ClassRecord\Models\Student;
use Modules\ClassRecord\Models\Attendance;
use Modules\ClassRecord\Models\Grade;
use Illuminate\Support\Carbon;

class ClassRecordDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 2 classes
        $classes = [
            '6º Ano A',
            '7º Ano B',
        ];

        foreach ($classes as $className) {
            $class = SchoolClass::create(['name' => $className]);

            // Create 10 students per class
            for ($i = 1; $i <= 10; $i++) {
                $student = Student::create([
                    'name' => "Student $i of $className",
                    'school_class_id' => $class->id,
                ]);

                // Create attendance for the last 5 days
                for ($d = 0; $d < 5; $d++) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'school_class_id' => $class->id,
                        'date' => Carbon::now()->subDays($d)->format('Y-m-d'),
                        'status' => rand(0, 10) > 2 ? 'present' : 'absent', // 80% attendance
                    ]);
                }

                // Create grades
                // Make some students fail intentionally (id % 3 == 0)
                $score = ($i % 3 == 0) ? rand(200, 490) / 100 : rand(500, 1000) / 100;

                Grade::create([
                    'student_id' => $student->id,
                    'subject' => 'Math',
                    'score' => $score,
                ]);
            }
        }
    }
}
