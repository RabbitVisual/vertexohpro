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
        // Get or create a system user for ownership if none exists
        $user = \App\Models\User::first() ?: \App\Models\User::factory()->create();

        // Create 2 classes
        $classes = [
            '6º Ano A',
            '7º Ano B',
        ];

        foreach ($classes as $className) {
            $class = SchoolClass::create([
                'name' => $className,
                'user_id' => $user->id,
                'year' => '2026',
                'subject' => 'Geral'
            ]);

            // Create 10 students per class
            for ($i = 1; $i <= 10; $i++) {
                $student = Student::create([
                    'name' => "Student $i of $className",
                    'class_id' => $class->id,
                    'email' => "student{$i}.{$class->id}@example.com",
                    'guardian_email' => "guardian{$i}.{$class->id}@example.com",
                ]);

                // Create attendance for the last 5 days
                for ($d = 0; $d < 5; $d++) {
                    Attendance::create([
                        'student_id' => $student->id,
                        'class_id' => $class->id,
                        'date' => Carbon::now()->subDays($d)->format('Y-m-d'),
                        'status' => rand(0, 10) > 2 ? 'present' : 'absent', // 80% attendance
                    ]);
                }

                // Create cycle grades (4 cycles)
                for ($c = 1; $c <= 4; $c++) {
                    // 3 evaluations per cycle
                    for ($e = 1; $e <= 3; $e++) {
                        Grade::create([
                            'student_id' => $student->id,
                            'class_id' => $class->id,
                            'subject' => 'Matemática',
                            'cycle' => $c,
                            'evaluation_number' => $e,
                            'score' => rand(300, 1000) / 100,
                            'bncc_skill_code' => "EF06MA0" . rand(1, 9),
                        ]);
                    }
                }
            }
        }
    }
}
